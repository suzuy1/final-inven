<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $guarded = ['id'];

    public function category() { return $this->belongsTo(Category::class); }
    
    // Satu jenis barang punya banyak unit fisik
    public function details() { return $this->hasMany(AssetDetail::class); }
}