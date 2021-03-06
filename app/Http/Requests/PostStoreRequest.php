<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'id'          => ['numeric'],
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
