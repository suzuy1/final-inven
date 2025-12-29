<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => \App\Enums\LoanStatus::class,
        'loan_date' => 'date',
        'return_date_plan' => 'date',
        'return_date_actual' => 'date',
    ];

    // Relasi ke Unit Barang
    public function asset()
    {
        return $this->belongsTo(AssetDetail::class, 'asset_detail_id');
    }

    // Accessor: Check Overdue
    public function getIsOverdueAttribute()
    {
        return $this->status == 'dipinjam' && now() > $this->return_date_plan;
    }
}