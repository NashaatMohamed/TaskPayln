<?php

namespace App\Models;


use App\Traits\HasActivation;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class BaseModel extends Model implements HasMedia
{
    use InteractsWithMedia , HasActivation;

    public function storeImages($media, $update = false, $collection = 'images'): void
    {
        $images = array_filter(convertToArray($media));
        if ($update && !empty($images)) {
            $this->deleteMedia(collection: $collection);
        }
        if (!empty($images)) {
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $this->addMedia($image)->toMediaCollection($collection);
                }
            }
        }
    }

    public function deleteMedia($collection = 'images'): void
    {
        $media = $this->getMedia($collection);
        foreach ($media as $m) {
            $m->delete();
        }
    }

    public function getImages($collection = 'images'): array
    {
        return $this->getMedia($collection)->map(fn($media) => $media->getUrl());
    }

    public function getImage($collection = 'images'): ?string
    {
        return $this->getFirstMediaUrl($collection) ?: null;
    }

}

