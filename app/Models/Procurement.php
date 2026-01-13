<?php

namespace App\Models;

use App\Enums\ProcurementStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Procurement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => ProcurementStatus::class,
        'unit_price_estimation' => 'decimal:2',
        'request_date' => 'date',
        'response_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke User (Pengaju)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', ProcurementStatus::PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', ProcurementStatus::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', ProcurementStatus::REJECTED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', ProcurementStatus::COMPLETED);
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->role !== 'admin') {
            return $query->where('user_id', $user->id);
        }
        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS LOGIC
    |--------------------------------------------------------------------------
    */

    /**
     * Check if procurement can be approved
     */
    public function canBeApproved(): bool
    {
        return $this->status === ProcurementStatus::PENDING;
    }

    /**
     * Check if procurement can be completed
     */
    public function canBeCompleted(): bool
    {
        return $this->status === ProcurementStatus::APPROVED;
    }

    /**
     * Check if procurement can be deleted
     */
    public function canBeDeleted(User $user): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $this->user_id === $user->id && $this->status === ProcurementStatus::PENDING;
    }

    /**
     * Get total estimated value
     */
    public function getTotalValueAttribute(): float
    {
        return ($this->unit_price_estimation ?? 0) * $this->quantity;
    }
}