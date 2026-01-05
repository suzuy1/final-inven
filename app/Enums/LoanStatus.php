<?php

namespace App\Enums;

enum LoanStatus: string
{
    case DIPINJAM = 'dipinjam';
    case KEMBALI = 'kembali';
    // Note: 'overdue' is a calculated state (dipinjam + past due date), not stored in DB

    public function label(): string
    {
        return match ($this) {
            self::DIPINJAM => 'Sedang Dipinjam',
            self::KEMBALI => 'Sudah Kembali',
        };
    }
}
