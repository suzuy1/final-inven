<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = ['id'];

    // Satu Unit punya banyak Ruangan
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
