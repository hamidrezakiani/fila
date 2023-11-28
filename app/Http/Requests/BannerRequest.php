<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'slog' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
