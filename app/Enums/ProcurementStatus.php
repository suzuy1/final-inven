<?php

namespace App\Enums;

enum ProcurementStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu Persetujuan',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
            self::COMPLETED => 'Selesai',
        };
    }

    /**
     * Get color theme for UI
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'amber',
            self::APPROVED => 'emerald',
            self::REJECTED => 'rose',
            self::COMPLETED => 'indigo',
        };
    }

    /**
     * Get Tailwind CSS classes for badges
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::PENDING => 'bg-amber-50 text-amber-700 border-amber-200',
            self::APPROVED => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            self::REJECTED => 'bg-rose-50 text-rose-700 border-rose-200',
            self::COMPLETED => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        };
    }

    /**
     * Get SVG icon path
     */
    public function iconPath(): string
    {
        return match ($this) {
            self::PENDING => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            self::APPROVED => 'M5 13l4 4L19 7',
            self::REJECTED => 'M6 18L18 6M6 6l12 12',
            self::COMPLETED => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        };
    }

    /**
     * Check if status can be changed to another status
     */
    public function canTransitionTo(self $newStatus): bool
    {
        return match ($this) {
            self::PENDING => in_array($newStatus, [self::APPROVED, self::REJECTED]),
            self::APPROVED => $newStatus === self::COMPLETED,
            self::REJECTED, self::COMPLETED => false,
        };
    }
}
