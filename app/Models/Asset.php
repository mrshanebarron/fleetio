<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'make',
        'model',
        'year',
        'vin',
        'license_plate',
        'status',
        'group',
        'photo',
        'current_meter_value',
        'meter_unit',
        'assigned_to',
    ];

    protected function casts(): array
    {
        return [
            'current_meter_value' => 'decimal:1',
            'year' => 'integer',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function meters(): HasMany
    {
        return $this->hasMany(AssetMeter::class)->orderByDesc('recorded_at');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function maintenanceSchedules(): HasMany
    {
        return $this->hasMany(MaintenanceSchedule::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function getDisplayNameAttribute(): string
    {
        $parts = array_filter([$this->year, $this->make, $this->model]);
        return $parts ? implode(' ', $parts) : $this->name;
    }
}
