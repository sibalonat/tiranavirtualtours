<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Station extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public static function booted()
    {
        static::creating(function (Station $station) {
            $station->uuid = Str::uuid();
            if (!$station->slug) {
                $station->slug = $station->uuid;
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('stationArr')
        ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);

        $this->addMediaCollection('imgAudio')
        ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);

        $this->addMediaCollection('threeDObject')
        ->singleFile();

        $this->addMediaCollection('videos')
        ->acceptsMimeTypes(['video/mp4']);

        $this->addMediaCollection('audios')
        ->acceptsMimeTypes(['audio/mp3', 'audio/mpeg']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(600)
            ->height(600)
            ->performOnCollections('videos');

        $this->addMediaConversion('thumbimg')
            ->width(600)
            ->height(600)
            ->crop(Manipulations::CROP_TOP_RIGHT, 600, 600)
            ->performOnCollections('stationArr');

        $this->addMediaConversion('thumbimgaudio')
            ->width(600)
            ->height(600)
            ->crop(Manipulations::CROP_TOP_RIGHT, 600, 600)
            ->performOnCollections('imgAudio');
    }

    protected $fillable = [
        'slug',
        'uuid',
        'teaser_en',
        'teaser_al',
        'tour_id',
        'lng',
        'lat', '
        title_en',
        'title_al',
        'author_al',
        'author_en'
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
