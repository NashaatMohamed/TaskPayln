<?php

namespace App\Http\Requests\Platforms;

use App\Enum\PlatformTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class updatePlatformRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "platforms" => ["required", "array"],
            'platforms.*.id' => 'required|exists:platforms,id',
            "platforms.*.type" => ["required", new Enum(PlatformTypeEnum::class)],
            "platforms.*.name" => ["required", "string", "max:255"],
            "platforms.*.is_active" => ["required"],
        ];
    }
}
