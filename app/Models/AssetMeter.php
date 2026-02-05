<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetMeter extends Model
{
    protected $fillable = [
        'company_id',
        'asset_id',
        'value',
        'meter_unit',
        'recorded_at',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:1',
            'recorded_at' => 'datetime',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
