<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FatModel extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function (FatModel $fatModel) {
            for ($i = 0; $i < 100; $i++) {
                // Count to 100 for some reason
            }
            \Log::info('updating model');
        });

        static::deleting(function (FatModel $fatModel) {
            for ($i = 0; $i < 100; $i++) {
                // Count to 100 for some reason
            }
            \Log::info('deleting model');
        });

        static::creating(function (FatModel $fatModel) {
            for ($i = 0; $i < 100; $i++) {
                // Count to 100 for some reason
            }
            \Log::info('creating model');
        });
    }

    // Accessors
    public function getCreatedAtDayAttribute(): string
    {
        return $this->created_at->format('d');
    }

    public function getCreatedAtDayAsStringAttribute(): string
    {
        return $this->created_at->format('l');
    }

    public function getUpdatedAtMonthAttribute(): string
    {
        return $this->updated_at->format('m');
    }

    public function getUpdatedAtYearAttribute(): string
    {
        return $this->updated_at->format('Y');
    }

    // Mutators
    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = strtolower($value);
    }

    public function setActiveAttribute(string $value): void
    {
        $this->attributes['active'] = $value === 'true';
    }

    public function setWeightAttribute(float $value): void
    {
        $this->attributes['weight'] = round($value, 2);
    }

    public function setDescriptionAttribute(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', 1);
    }

    public function scopeWithDescription(Builder $query): Builder
    {
        return $query->whereNotNull('description');
    }

    public function scopeWhereWeightBetween(Builder $query, int $from, int $to): Builder
    {
        return $query->whereBetween('weight', [$from, $to]);
    }

    public function scopeWhereFirstNameLike(Builder $query, string $like): Builder
    {
        return $query->where('name', 'LIKE', "%{$like}%");
    }
}
