<?php

namespace App\Models;

use App\Enums\RequisitionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => RequisitionStatus::class,
        'unit_price' => 'decimal:2',
        'request_date' => 'date',
        'response_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke User (Pemohon)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', RequisitionStatus::PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', RequisitionStatus::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', RequisitionStatus::REJECTED);
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
     * Check if requisition can be approved
     */
    public function canBeApproved(): bool
    {
        return $this->status === RequisitionStatus::PENDING;
    }

    /**
     * Check if requisition can be deleted
     */
    public function canBeDeleted(User $user): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $this->user_id === $user->id && $this->status === RequisitionStatus::PENDING;
    }
}
