<?php

use App\Enums\ProcurementStatus;
use App\Models\Category;
use App\Models\Procurement;
use App\Models\User;

beforeEach(function () {
    // Create categories for testing
    $this->assetCategory = Category::create([
        'name' => 'Elektronik',
        'code' => 'ELK',
        'type' => 'asset',
    ]);

    $this->consumableCategory = Category::create([
        'name' => 'ATK',
        'code' => 'ATK',
        'type' => 'consumable',
    ]);

    // Create users
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->staff = User::factory()->create(['role' => 'user']);
});

describe('Procurement Index', function () {
    it('shows procurement list for authenticated users', function () {
        $this->actingAs($this->staff)
            ->get(route('pengadaan.index'))
            ->assertStatus(200)
            ->assertSee('Usulan Pengadaan');
    });

    it('shows only user\'s own procurements for non-admin', function () {
        // Create procurements for different users
        $staffProcurement = Procurement::create([
            'item_name' => 'Laptop Staff',
            'type' => 'asset',
            'quantity' => 1,
            'category_id' => $this->assetCategory->id,
            'user_id' => $this->staff->id,
            'requestor_name' => $this->staff->name,
            'status' => ProcurementStatus::PENDING,
            'request_date' => now(),
        ]);

        $adminProcurement = Procurement::create([
            'item_name' => 'Laptop Admin',
            'type' => 'asset',
            'quantity' => 1,
            'category_id' => $this->assetCategory->id,
            'user_id' => $this->admin->id,
            'requestor_name' => $this->admin->name,
            'status' => ProcurementStatus::PENDING,
            'request_date' => now(),
        ]);

        // Staff should only see their own procurement
        $this->actingAs($this->staff)
            ->get(route('pengadaan.index'))
            ->assertSee('Laptop Staff')
            ->assertDontSee('Laptop Admin');

        // Admin should see all procurements
        $this->actingAs($this->admin)
            ->get(route('pengadaan.index'))
            ->assertSee('Laptop Staff')
            ->assertSee('Laptop Admin');
    });
});

describe('Procurement Creation', function () {
    it('allows authenticated users to access create form', function () {
        $this->actingAs($this->staff)
            ->get(route('pengadaan.create'))
            ->assertStatus(200);
    });

    it('creates a new procurement request', function () {
        $data = [
            'item_name' => 'Printer HP LaserJet',
            'type' => 'asset',
            'quantity' => 2,
            'category_id' => $this->assetCategory->id,
            'description' => 'Untuk kebutuhan kantor',
            'unit_price_estimation' => 2500000,
        ];

        $this->actingAs($this->staff)
            ->post(route('pengadaan.store'), $data)
            ->assertRedirect(route('pengadaan.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('procurements', [
            'item_name' => 'Printer HP LaserJet',
            'type' => 'asset',
            'quantity' => 2,
            'user_id' => $this->staff->id,
            'status' => ProcurementStatus::PENDING->value,
        ]);
    });

    it('validates required fields', function () {
        $this->actingAs($this->staff)
            ->post(route('pengadaan.store'), [])
            ->assertSessionHasErrors(['item_name', 'type', 'quantity', 'category_id']);
    });
});

describe('Procurement Approval', function () {
    beforeEach(function () {
        $this->procurement = Procurement::create([
            'item_name' => 'Test Item',
            'type' => 'asset',
            'quantity' => 1,
            'category_id' => $this->assetCategory->id,
            'user_id' => $this->staff->id,
            'requestor_name' => $this->staff->name,
            'status' => ProcurementStatus::PENDING,
            'request_date' => now(),
        ]);
    });

    it('allows admin to approve procurement', function () {
        $this->actingAs($this->admin)
            ->put(route('pengadaan.updateStatus', $this->procurement), [
                'status' => 'approved',
                'admin_note' => 'Disetujui untuk pembelian',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->procurement->refresh();
        expect($this->procurement->status)->toBe(ProcurementStatus::APPROVED);
    });

    it('allows admin to reject procurement', function () {
        $this->actingAs($this->admin)
            ->put(route('pengadaan.updateStatus', $this->procurement), [
                'status' => 'rejected',
                'admin_note' => 'Budget tidak mencukupi',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->procurement->refresh();
        expect($this->procurement->status)->toBe(ProcurementStatus::REJECTED);
    });

    it('prevents non-admin from updating status', function () {
        $this->actingAs($this->staff)
            ->put(route('pengadaan.updateStatus', $this->procurement), [
                'status' => 'approved',
            ])
            ->assertForbidden();
    });

    it('prevents invalid status transitions', function () {
        // First approve it
        $this->procurement->update(['status' => ProcurementStatus::APPROVED]);

        // Try to reject (invalid transition from approved)
        $this->actingAs($this->admin)
            ->put(route('pengadaan.updateStatus', $this->procurement), [
                'status' => 'rejected',
            ])
            ->assertSessionHasErrors('status');
    });
});

describe('Procurement Completion', function () {
    beforeEach(function () {
        $this->procurement = Procurement::create([
            'item_name' => 'Test Item',
            'type' => 'asset',
            'quantity' => 5,
            'category_id' => $this->assetCategory->id,
            'user_id' => $this->staff->id,
            'requestor_name' => $this->staff->name,
            'status' => ProcurementStatus::APPROVED,
            'request_date' => now(),
        ]);
    });

    it('allows admin to complete procurement without stock', function () {
        $this->actingAs($this->admin)
            ->put(route('pengadaan.updateStatus', $this->procurement), [
                'status' => 'completed',
                'admin_note' => 'Selesai',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->procurement->refresh();
        expect($this->procurement->status)->toBe(ProcurementStatus::COMPLETED);
    });
});

describe('Procurement Deletion', function () {
    it('allows user to delete own pending procurement', function () {
        $procurement = Procurement::create([
            'item_name' => 'To Be Deleted',
            'type' => 'asset',
            'quantity' => 1,
            'category_id' => $this->assetCategory->id,
            'user_id' => $this->staff->id,
            'requestor_name' => $this->staff->name,
            'status' => ProcurementStatus::PENDING,
            'request_date' => now(),
        ]);

        $this->actingAs($this->staff)
            ->delete(route('pengadaan.destroy', $procurement))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('procurements', ['id' => $procurement->id]);
    });

    it('prevents user from deleting approved procurement', function () {
        $procurement = Procurement::create([
            'item_name' => 'Already Approved',
            'type' => 'asset',
            'quantity' => 1,
            'category_id' => $this->assetCategory->id,
            'user_id' => $this->staff->id,
            'requestor_name' => $this->staff->name,
            'status' => ProcurementStatus::APPROVED,
            'request_date' => now(),
        ]);

        $this->actingAs($this->staff)
            ->delete(route('pengadaan.destroy', $procurement))
            ->assertForbidden();
    });

    it('allows admin to delete any procurement', function () {
        $procurement = Procurement::create([
            'item_name' => 'Admin Delete Test',
            'type' => 'asset',
            'quantity' => 1,
            'category_id' => $this->assetCategory->id,
            'user_id' => $this->staff->id,
            'requestor_name' => $this->staff->name,
            'status' => ProcurementStatus::APPROVED,
            'request_date' => now(),
        ]);

        $this->actingAs($this->admin)
            ->delete(route('pengadaan.destroy', $procurement))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('procurements', ['id' => $procurement->id]);
    });
});

describe('Procurement Model Methods', function () {
    it('correctly identifies if procurement can be approved', function () {
        $pending = new Procurement(['status' => ProcurementStatus::PENDING]);
        $approved = new Procurement(['status' => ProcurementStatus::APPROVED]);

        expect($pending->canBeApproved())->toBeTrue();
        expect($approved->canBeApproved())->toBeFalse();
    });

    it('correctly identifies if procurement can be completed', function () {
        $approved = new Procurement(['status' => ProcurementStatus::APPROVED]);
        $pending = new Procurement(['status' => ProcurementStatus::PENDING]);

        expect($approved->canBeCompleted())->toBeTrue();
        expect($pending->canBeCompleted())->toBeFalse();
    });

    it('calculates total value correctly', function () {
        $procurement = new Procurement([
            'unit_price_estimation' => 1500000,
            'quantity' => 3,
        ]);

        expect($procurement->total_value)->toBe(4500000.0);
    });
});

