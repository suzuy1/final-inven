<?php

namespace App\Enums;

enum LoanStatus: string
{
    case DIPINJAM = 'dipinjam';
    case KEMBALI = 'kembali';
    case OVERDUE = 'overdue'; // Though 'overdue' is often a calculated state, sometimes it's stored. Based on the view, it seems 'overdue' might be a filter option or state. Let's check the code.
    // In the view: request('status') == 'overdue'. It's a filter value.
    // The DB value seems to be 'dipinjam' or 'kembali'.

    public function label(): string
    {
        return match ($this) {
            self::DIPINJAM => 'Sedang Dipinjam',
            self::KEMBALI => 'Sudah Kembali',
            self::OVERDUE => 'Terlambat',
        };
    }
}
