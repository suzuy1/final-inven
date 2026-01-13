<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Simple Activity Logger Service
 * 
 * For more advanced features, consider using spatie/laravel-activitylog package
 */
class ActivityLogService
{
    /**
     * Log an activity
     *
     * @param string $action Action performed (created, updated, deleted, approved, etc.)
     * @param Model $model The model being acted upon
     * @param array $properties Additional properties to log
     */
    public static function log(string $action, Model $model, array $properties = []): void
    {
        $user = Auth::user();
        
        $logData = [
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'user_role' => $user?->role,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toIso8601String(),
        ];

        // Log to Laravel's default log
        Log::channel('activity')->info("Activity: {$action}", $logData);
    }

    /**
     * Log procurement activity
     */
    public static function logProcurement(string $action, Model $procurement, array $extra = []): void
    {
        self::log($action, $procurement, array_merge([
            'item_name' => $procurement->item_name ?? null,
            'status' => $procurement->status?->value ?? $procurement->status,
            'quantity' => $procurement->quantity ?? null,
        ], $extra));
    }

    /**
     * Log disposal activity
     */
    public static function logDisposal(string $action, Model $disposal, array $extra = []): void
    {
        self::log($action, $disposal, array_merge([
            'asset_id' => $disposal->asset_detail_id ?? null,
            'status' => $disposal->status?->value ?? $disposal->status,
            'disposal_type' => $disposal->disposal_type?->value ?? $disposal->disposal_type,
        ], $extra));
    }

    /**
     * Log asset activity
     */
    public static function logAsset(string $action, Model $asset, array $extra = []): void
    {
        self::log($action, $asset, array_merge([
            'asset_code' => $asset->asset_code ?? null,
            'status' => $asset->status?->value ?? $asset->status,
            'condition' => $asset->condition?->value ?? $asset->condition,
        ], $extra));
    }

    /**
     * Log loan activity
     */
    public static function logLoan(string $action, Model $loan, array $extra = []): void
    {
        self::log($action, $loan, array_merge([
            'asset_id' => $loan->asset_detail_id ?? null,
            'borrower' => $loan->borrower_name ?? null,
            'status' => $loan->status?->value ?? $loan->status,
        ], $extra));
    }

    /**
     * Log mutation activity
     */
    public static function logMutation(string $action, Model $mutation, array $extra = []): void
    {
        self::log($action, $mutation, array_merge([
            'asset_id' => $mutation->asset_detail_id ?? null,
            'from_room' => $mutation->from_room_id ?? null,
            'to_room' => $mutation->to_room_id ?? null,
            'status' => $mutation->status?->value ?? $mutation->status,
        ], $extra));
    }
}
