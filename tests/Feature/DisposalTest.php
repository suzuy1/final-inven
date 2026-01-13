<?php

use App\Enums\AssetCondition;
use App\Enums\AssetStatus;
use App\Enums\DisposalStatus;
use App\Enums\DisposalType;
use App\Models\AssetDetail;
use App\Models\Category;
use App\Models\Disposal;
use App\Models\Inventory;
use App\Models\User;

beforeEach(function () {
    // Create category
    $this->category = Category::create([
        'name' => 'Elektronik',
        'code' => 'ELK',
        'type' => 'asset',
    ]);

    // Create inventory
    $this->inventory = Inventory::create([
        'name' => 'Laptop',
        'category_id' => $this->category->id,
    ]);

    // Create asset
    $this->asset = AssetDetail::create([
        'inventory_id' => $this->inventory->id,
        'asset_code' => 'AST-001',
        'condition' => AssetCondition::BAIK,
        'status' => AssetStatus::TERSEDIA,
        'price' => 5000000,
        'acquisition_date' => now(),
    ]);

    // Create users
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->staff = User::factory()->create(['role' => 'user']);
});

describe('Disposal Index', function () {
    it('shows disposal list for authenticated users', function () {
        $this->actingAs($this->staff)
            ->get(route('disposals.index'))
            ->assertStatus(200);
    });
});

describe('Disposal Creation', function () {
    it('allows users to create disposal request', function () {
        $this->actingAs($this->staff)
            ->post(route('disposals.store'), [
                'asset_detail_id' => $this->asset->id,
                'disposal_type' => DisposalType::RUSAK->value,
                'reason' => 'Laptop sudah tidak bisa digunakan',
                'estimated_value' => 500000,
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('disposals', [
            'asset_detail_id' => $this->asset->id,
            'status' => DisposalStatus::PENDING->value,
        ]);
    });
});

describe('Disposal Approval', function () {
    beforeEach(function () {
        $this->disposal = Disposal::create([
            'asset_detail_id' => $this->asset->id,
            'disposal_type' => DisposalType::RUSAK,
            'reason' => 'Test reason',
            'status' => DisposalStatus::PENDING,
            'requested_by' => $this->staff->id,
            'estimated_value' => 500000,
        ]);
    });

    it('allows admin to access review page', function () {
        $this->actingAs($this->admin)
            ->get(route('disposals.review', $this->disposal))
            ->assertStatus(200);
    });

    it('allows admin to approve disposal', function () {
        $this->actingAs($this->admin)
            ->post(route('disposals.approve', $this->disposal), [
                'notes' => 'Disetujui untuk dihapuskan',
                'realized_value' => 300000,
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->disposal->refresh();
        expect($this->disposal->status)->toBe(DisposalStatus::APPROVED);

        // Asset should be soft deleted
        $this->asset->refresh();
        expect($this->asset->trashed())->toBeTrue();
    });

    it('allows admin to reject disposal', function () {
        $this->actingAs($this->admin)
            ->post(route('disposals.reject', $this->disposal), [
                'notes' => 'Masih bisa diperbaiki',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->disposal->refresh();
        expect($this->disposal->status)->toBe(DisposalStatus::REJECTED);

        // Asset should NOT be soft deleted
        $this->asset->refresh();
        expect($this->asset->trashed())->toBeFalse();
    });

    it('prevents non-admin from approving disposal', function () {
        $this->actingAs($this->staff)
            ->post(route('disposals.approve', $this->disposal), [
                'notes' => 'Trying to approve',
            ])
            ->assertForbidden();
    });
});

describe('Disposal Model Methods', function () {
    it('correctly identifies if disposal can be approved', function () {
        $this->disposal = Disposal::create([
            'asset_detail_id' => $this->asset->id,
            'disposal_type' => DisposalType::RUSAK,
            'reason' => 'Test',
            'status' => DisposalStatus::PENDING,
            'requested_by' => $this->staff->id,
        ]);

        expect($this->disposal->canBeApproved())->toBeTrue();

        // Change status to approved
        $this->disposal->update(['status' => DisposalStatus::APPROVED]);
        expect($this->disposal->canBeApproved())->toBeFalse();
    });
});

describe('Disposal Policy', function () {
    it('allows admin to view any disposal', function () {
        $disposal = Disposal::create([
            'asset_detail_id' => $this->asset->id,
            'disposal_type' => DisposalType::RUSAK,
            'reason' => 'Test',
            'status' => DisposalStatus::PENDING,
            'requested_by' => $this->staff->id,
        ]);

        $this->actingAs($this->admin)
            ->get(route('disposals.show', $disposal))
            ->assertStatus(200);
    });

    it('allows requester to view own disposal', function () {
        $disposal = Disposal::create([
            'asset_detail_id' => $this->asset->id,
            'disposal_type' => DisposalType::RUSAK,
            'reason' => 'Test',
            'status' => DisposalStatus::PENDING,
            'requested_by' => $this->staff->id,
        ]);

        $this->actingAs($this->staff)
            ->get(route('disposals.show', $disposal))
            ->assertStatus(200);
    });
});
