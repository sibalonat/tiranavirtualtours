<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = ['camera', 'audio', 'ar', 'location'];

    protected $casts = [
        'camera' => 'boolean',
        'audio' => 'boolean',
        'ar' => 'boolean',
        'location' => 'boolean',
    ];

}
