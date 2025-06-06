<?php

namespace App\Http\Resources;

use App\Enum\PlatformTypeEnum;
use App\Factory\EnumFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            "type" => EnumFactory::getName(enumClass: PlatformTypeEnum::class, value: $this->type ?? null),
            "is_active" => $this->getActiveStatus()->label()
        ];
    }
}
