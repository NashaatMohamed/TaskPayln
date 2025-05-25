<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

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
            "platforms" => "nullable|array",
            "platforms.*" => ["nullable", "exists:platforms,id"]
        ];
    }
}
