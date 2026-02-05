<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'logo',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
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

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
