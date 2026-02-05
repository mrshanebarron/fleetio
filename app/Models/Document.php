<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'documentable_type',
        'documentable_id',
        'title',
        'file_path',
        'file_type',
        'expires_at',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isFuture() && $this->expires_at->diffInDays(now()) <= 30;
    }
}
