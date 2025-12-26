<?php

namespace App\Enums;

enum AssetStatus: string
{
    case TERSEDIA = 'tersedia';
    case DIPINJAM = 'dipinjam';
    case RUSAK = 'rusak';
    case DIHAPUSKAN = 'dihapuskan';

    public function label(): string
    {
        return match ($this) {
            self::TERSEDIA => 'Tersedia',
            self::DIPINJAM => 'Sedang Dipinjam',
            self::RUSAK => 'Rusak',
            self::DIHAPUSKAN => 'Dihapuskan',
        };
    }
}
