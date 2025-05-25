<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => ["nullable", "string", "max:255"],
            "email" => ["nullable", "email:filter", "max:255", "unique:users,email," . $this->user()->id],
            "password" => ["nullable", "string", "min:8", "max:255", "confirmed"],
            "password_confirmation" => ["nullable", "string", "min:8", "max:255"],
        ];
    }
}
