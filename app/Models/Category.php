<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'color',
        'icon',
    ];

    public function receiptItems(): HasMany
    {
        return $this->hasMany(ReceiptItem::class);
    }
}
