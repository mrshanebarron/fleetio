<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderLabor extends Model
{
    protected $table = 'work_order_labor';

    protected $fillable = [
        'work_order_id',
        'technician_id',
        'description',
        'hours',
        'hourly_rate',
    ];

    protected function casts(): array
    {
        return [
            'hours' => 'decimal:2',
            'hourly_rate' => 'decimal:2',
        ];
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function getTotalCostAttribute(): float
    {
        return (float) $this->hours * (float) $this->hourly_rate;
    }
}
