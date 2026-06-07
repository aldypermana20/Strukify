<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receipt extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'receipt_date',
        'total',
        'image_path',
        'status',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReceiptItem::class);
    }

    protected static function booted()
    {
        $clearCache = function ($receipt) {
            if ($receipt->user_id) {
                $month = \Carbon\Carbon::parse($receipt->receipt_date ?? now())->month;
                $year = \Carbon\Carbon::parse($receipt->receipt_date ?? now())->year;
                \Illuminate\Support\Facades\Cache::forget("dashboard_data_{$receipt->user_id}_{$year}_{$month}");
            }
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }
}
