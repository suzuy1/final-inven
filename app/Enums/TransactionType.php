<?php

namespace App\Enums;

enum TransactionType: string
{
    case MASUK = 'masuk';
    case KELUAR = 'keluar';

    public function label(): string
    {
        return match ($this) {
            self::MASUK => 'Stok Masuk',
            self::KELUAR => 'Stok Keluar',
        };
    }
}
