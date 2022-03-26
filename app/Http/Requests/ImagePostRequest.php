<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImagePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'avatar' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10240'],
            'banner' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10240'],
        ];
    }
}
