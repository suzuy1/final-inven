<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $guarded = ['id'];

    /**
     * Relasi ke User (Pemohon)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Relasi ke Category
     * Satu Requisition dimiliki oleh satu Category
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
