<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImagePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'avatar' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png,jpeg', 'max:1024'],
            'banner' => ['sometimes', 'nullable', 'image', 'mimes:jpg,png,jpeg', 'max:1024']
        ];
    }
}
