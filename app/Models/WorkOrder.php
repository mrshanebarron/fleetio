<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'asset_id',
        'number',
        'title',
        'description',
        'priority',
        'status',
        'assigned_to',
        'vendor_id',
        'started_at',
        'completed_at',
        'total_parts_cost',
        'total_labor_cost',
        'downtime_hours',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'total_parts_cost' => 'decimal:2',
            'total_labor_cost' => 'decimal:2',
            'downtime_hours' => 'decimal:1',
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

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parts(): HasMany
    {
        return $this->hasMany(WorkOrderPart::class);
    }

    public function labor(): HasMany
    {
        return $this->hasMany(WorkOrderLabor::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function getTotalCostAttribute(): float
    {
        return (float) $this->total_parts_cost + (float) $this->total_labor_cost;
    }

    public function recalculateCosts(): void
    {
        $this->update([
            'total_parts_cost' => $this->parts()->sum(\DB::raw('quantity * unit_cost')),
            'total_labor_cost' => $this->labor()->sum(\DB::raw('hours * hourly_rate')),
        ]);
    }

    protected static function booted(): void
    {
        static::creating(function (WorkOrder $wo) {
            if (empty($wo->number)) {
                $lastNumber = static::where('company_id', $wo->company_id)
                    ->withTrashed()
                    ->max('id');
                $wo->number = 'WO-' . str_pad(($lastNumber ?? 0) + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
