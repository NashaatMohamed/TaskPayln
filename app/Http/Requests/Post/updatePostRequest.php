<?php

namespace App\Http\Requests\Post;

use App\Enum\PostStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class updatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "title" => "nullable|string",
            "content" => "nullable|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "scheduled_time" => ["nullable", "date","after_or_equal:now"],
            "status" => ["nullable", new Enum(PostStatusEnum::class)],
            "platforms" => "nullable|array",
            "platforms.*" => ["nullable", "exists:platforms,id"]
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            "scheduled_time" => covertCreatedAtWithTime($this->scheduled_time ?? null),
        ]);
    }
}
