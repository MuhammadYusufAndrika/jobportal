<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'salary',
        'deadline',
        'application_form',
        'is_active',
        'user_id',
    ];

    protected $casts = [
        'application_form' => 'array',
        'deadline' => 'date',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function isActive(): bool
    {
        return $this->is_active && $this->deadline >= now()->toDateString();
    }

    public function getLocationOptions(): array
    {
        return [
            'Martapura',
            'Belitang',
            'Belitang Hilir',
            'Belitang Hulu',
            'Belitang Jaya',
            'Cit',
            'Pedamaran',
            'Semendawai Suku III',
            'Semendawai Timur',
            'Sirah Pulau Padang',
            'Sosok'
        ];
    }
}
