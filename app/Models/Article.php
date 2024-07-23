<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\CropPosition;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

class Article extends Model implements HasMedia
{
    use HasFactory, HasTags, HasTranslations, InteractsWithMedia;

    protected array $translatable = ['title', 'content', 'slug'];

    protected $appends = ['tags'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->crop(320, 320)
            ->format('png');
    }

    public function getIllustrationAttribute(): string|null
    {
        $url = $this->getFirstMediaUrl('banner');
        return  $url !== '' ? $url : null;
    }

    public function getTagsAttribute()
    {
        return $this->tags()->get();
    }

    protected $casts = [
        'draft' => 'boolean',
    ];
}
