<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumable extends Model {
    protected $guarded = ['id'];
    public function category() { return $this->belongsTo(Category::class); }
    public function details() { return $this->hasMany(ConsumableDetail::class); }
}
