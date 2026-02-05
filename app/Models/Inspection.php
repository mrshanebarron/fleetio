<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'asset_id',
        'template_name',
        'inspector_id',
        'status',
        'notes',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
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

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InspectionItem::class)->orderBy('sort_order');
    }

    public function getFailedItemsCountAttribute(): int
    {
        return $this->items()->where('result', 'fail')->count();
    }
}
