<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'part_number',
        'description',
        'category',
        'quantity_on_hand',
        'minimum_quantity',
        'unit_cost',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'quantity_on_hand' => 'integer',
            'minimum_quantity' => 'integer',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity_on_hand <= $this->minimum_quantity;
    }
}
