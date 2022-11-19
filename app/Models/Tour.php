<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public static function booted()
    {
        static::creating(function(Tour $tour) {
            $tour->uuid = Str::uuid();
            if (!$tour->slug) {
                $tour->slug = $tour->uuid;
            }
        });
    }

    protected $fillable = ['uuid', 'title', 'slug', 'description_al', 'description_en'];

    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}
