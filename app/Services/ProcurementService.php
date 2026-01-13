<?php

namespace App\Services;

use App\Enums\ProcurementStatus;
use App\Enums\TransactionType;
use App\Models\Consumable;
use App\Models\ConsumableDetail;
use App\Models\Procurement;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogService;

class ProcurementService
{
    /**
     * Create a new procurement request
     */
    public function create(array $data, User $user): Procurement
    {
        return Procurement::create([
            'item_name' => $data['item_name'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'category_id' => $data['category_id'],
            'description' => $data['description'] ?? null,
            'unit_price_estimation' => $data['unit_price_estimation'] ?? null,
            'user_id' => $user->id,
            'requestor_name' => $user->name,
            'status' => ProcurementStatus::PENDING,
            'request_date' => now(),
        ]);

        ActivityLogService::logProcurement('created', $procurement);

        return $procurement;
    }

    /**
     * Approve a procurement request
     */
    public function approve(Procurement $procurement, ?string $note = null): bool
    {
        if (!$procurement->canBeApproved()) {
            return false;
        }

        $procurement->update([
            'status' => ProcurementStatus::APPROVED,
            'admin_note' => $note ?? 'Disetujui untuk proses pembelian',
            'response_date' => now(),
        ]);

        ActivityLogService::logProcurement('approved', $procurement);

        return true;
    }

    /**
     * Reject a procurement request
     */
    public function reject(Procurement $procurement, string $reason): bool
    {
        if (!$procurement->canBeApproved()) {
            return false;
        }

        $procurement->update([
            'status' => ProcurementStatus::REJECTED,
            'admin_note' => $reason,
            'response_date' => now(),
        ]);

        ActivityLogService::logProcurement('rejected', $procurement, ['reason' => $reason]);

        return true;
    }

    /**
     * Complete a procurement with stock addition
     */
    public function completeWithStock(
        Procurement $procurement,
        int $consumableId,
        string $batchCode,
        float $unitPrice,
        ?string $note = null
    ): bool {
        if (!$procurement->canBeCompleted()) {
            return false;
        }

        $consumable = Consumable::findOrFail($consumableId);

        return DB::transaction(function () use ($procurement, $consumable, $batchCode, $unitPrice, $note) {
            // 1. Create new batch (ConsumableDetail)
            $detail = ConsumableDetail::create([
                'consumable_id' => $consumable->id,
                'batch_code' => $batchCode,
                'initial_stock' => $procurement->quantity,
                'current_stock' => $procurement->quantity,
                'unit_price' => $unitPrice,
            ]);

            // 2. Record incoming transaction
            Transaction::create([
                'user_id' => Auth::id(),
                'consumable_detail_id' => $detail->id,
                'type' => TransactionType::MASUK,
                'amount' => $procurement->quantity,
                'date' => now(),
                'notes' => "Pengadaan Selesai: {$procurement->item_name} (ID: {$procurement->id}) | Kategori: " . ($procurement->category->name ?? '-'),
            ]);

            // 3. Update procurement status
            $procurement->update([
                'status' => ProcurementStatus::COMPLETED,
                'admin_note' => ($note ?? 'Selesai') . " (Masuk ke stok: {$consumable->name}, Batch: {$batchCode})",
                'response_date' => now(),
            ]);

            ActivityLogService::logProcurement('completed_with_stock', $procurement, [
                'consumable_id' => $consumable->id,
                'batch_code' => $batchCode,
                'quantity_added' => $procurement->quantity,
            ]);

            return true;
        });
    }

    /**
     * Complete a procurement without stock addition
     */
    public function completeWithoutStock(Procurement $procurement, ?string $note = null): bool
    {
        if (!$procurement->canBeCompleted()) {
            return false;
        }

        $procurement->update([
            'status' => ProcurementStatus::COMPLETED,
            'admin_note' => $note ?? 'Selesai tanpa input stok',
            'response_date' => now(),
        ]);

        ActivityLogService::logProcurement('completed', $procurement);

        return true;
    }

    /**
     * Delete a procurement
     */
    public function delete(Procurement $procurement, User $user): bool
    {
        if (!$procurement->canBeDeleted($user)) {
            return false;
        }

        ActivityLogService::logProcurement('deleted', $procurement);

        $procurement->delete();
        return true;
    }
}
