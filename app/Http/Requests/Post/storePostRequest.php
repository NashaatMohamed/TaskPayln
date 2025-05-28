<?php

namespace App\Http\Requests\Post;

use App\Enum\PlatformTypeEnum;
use App\Enum\PostStatusEnum;
use App\Models\Platform;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class storePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:255"],
            "content" => ["required", "string"],
            "image" => ["nullable", "image", "mimes:jpeg,png,jpg,gif,svg", "max:2048"],
            "scheduled_time" => ["nullable", "date","after_or_equal:now"],
            "status" => ["nullable", new Enum(PostStatusEnum::class)],
            "platforms" => ["required", "array"],
            "platforms.*" => ["required", "exists:platforms,id"],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $platformIds = $this->input("platforms", []);
            $content = $this->input("content");

            if (!is_array($platformIds) || empty($platformIds) || is_null($content)) {
                return;
            }

            $platforms = Platform::query()->whereIn("id", $platformIds)->get();

            foreach ($platforms as $platform) {
                $maxLength = match ($platform->type) {
                    PlatformTypeEnum::TWITTER->value => 280,
                    PlatformTypeEnum::INSTAGRAM->value => 5000,
                    PlatformTypeEnum::LINKEDIN->value => 1300,
                    default => 1000,
                };

                if (mb_strlen($content) > $maxLength) {
                    $validator->errors()->add(
                        'content',
                        "The content exceeds the maximum length of {$maxLength} characters for platform: {$platform->name}."
                    );
                }
            }
        });
    }

    public function prepareForValidation()
    {
        $this->merge([
            "scheduled_time" => covertCreatedAtWithTime($this->scheduled_time ?? null),
        ]);
    }
}
