<?php

namespace App\Models;

use App\Concerns\HasProfilePhotoPaths;
use App\Support\Media\InlineImageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Child extends Model
{
    use HasProfilePhotoPaths;

    protected $fillable = [
        'parent_id',
        'full_name',
        'date_of_birth',
        'gender',
        'class_name',
        'allergies',
        'health_notes',
        'special_notes',
        'profile_photo_original_path',
        'profile_photo_thumbnail_path',
        'profile_photo_optimized_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NurseryParent::class, 'parent_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ChildPayment::class);
    }

    public function weeklyReports(): HasMany
    {
        return $this->hasMany(ChildWeeklyReport::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('admin.children.class_names'));
        static::deleted(fn () => Cache::forget('admin.children.class_names'));

        static::deleting(function (self $child): void {
            app(InlineImageService::class)->deletePaths($child, 'profile_photo');
        });
    }
}
