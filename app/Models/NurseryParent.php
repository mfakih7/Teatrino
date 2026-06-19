<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NurseryParent extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'full_name',
        'phone_number',
        'whatsapp_number',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class, 'parent_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ChildPayment::class, 'parent_id');
    }

    public function weeklyReports(): HasMany
    {
        return $this->hasMany(ChildWeeklyReport::class, 'parent_id');
    }
}
