<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Bill extends Model implements HasMedia
{
    use InteractsWithMedia;
    public $fillable = [
        'bill_name',
        'description',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('preview')
            // ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('photo')
                    ->width(100)
                    ->height(100)
                    ->nonQueued(); #included this since we are not queueing conversions
            });
    }

}
