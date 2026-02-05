<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'asset_id',
        'name',
        'description',
        'schedule_type',
        'frequency_value',
        'frequency_unit',
        'last_completed_at',
        'last_meter_value',
        'next_due_at',
        'next_due_meter',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'last_completed_at' => 'datetime',
            'next_due_at' => 'datetime',
            'last_meter_value' => 'decimal:1',
            'next_due_meter' => 'decimal:1',
            'frequency_value' => 'integer',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->schedule_type === 'time_based' && $this->next_due_at) {
            return $this->next_due_at->isPast();
        }

        if ($this->schedule_type === 'meter_based' && $this->next_due_meter && $this->asset) {
            return $this->asset->current_meter_value >= $this->next_due_meter;
        }

        return false;
    }

    public function getIsUpcomingAttribute(): bool
    {
        if ($this->schedule_type === 'time_based' && $this->next_due_at) {
            return $this->next_due_at->isFuture() && $this->next_due_at->diffInDays(now()) <= 7;
        }

        if ($this->schedule_type === 'meter_based' && $this->next_due_meter && $this->asset) {
            $remaining = $this->next_due_meter - $this->asset->current_meter_value;
            return $remaining > 0 && $remaining <= 500;
        }

        return false;
    }
}
