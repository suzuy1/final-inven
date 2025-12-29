<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableDetail extends Model {
    protected $guarded = ['id'];
    public function consumable() { return $this->belongsTo(Consumable::class); }
    public function room() { return $this->belongsTo(Room::class); }
    public function fundingSource() { return $this->belongsTo(FundingSource::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
}