<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceiptItem extends Model
{
    protected $fillable = [
        'receipt_id',
        'category_id',
        'item_name',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted()
    {
        $clearCache = function ($item) {
            $receipt = $item->receipt;
            if ($receipt && $receipt->user_id) {
                $month = \Carbon\Carbon::parse($receipt->receipt_date ?? now())->month;
                $year = \Carbon\Carbon::parse($receipt->receipt_date ?? now())->year;
                \Illuminate\Support\Facades\Cache::forget("dashboard_data_{$receipt->user_id}_{$year}_{$month}");
            }
        };

        static::saved($clearCache);
        static::deleted($clearCache);
    }
}
