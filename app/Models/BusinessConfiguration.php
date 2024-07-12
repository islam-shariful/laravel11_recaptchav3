<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'group',
        'live_values',
        'test_values',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
