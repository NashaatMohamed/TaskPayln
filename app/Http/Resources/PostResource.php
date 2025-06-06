<?php

namespace App\Http\Resources;

use App\Enum\PostStatusEnum;
use App\Factory\EnumFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? null,
            'content' => $this->content ?? null,
            "image" => $this->getImage(),
            "scheduled_time" => $this->scheduled_time ?? null,
            "status" => EnumFactory::getName(enumClass: PostStatusEnum::class, value: $this->status ?? null),
            'created_at' => convertCreatedAt($this->created_at ?? null),
            'user' => new UserResource($this->whenLoaded('user')),
            "platforms" => PlatformResource::collection($this->whenLoaded('platforms')),
        ];
    }
}
