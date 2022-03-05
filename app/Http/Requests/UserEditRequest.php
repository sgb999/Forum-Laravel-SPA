<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'name' => ['string', 'max:255'],
            'username' => ['string', 'max:255', 'unique:users,username'],
            'email' => ['email', 'unique:users,email', 'max:255'],
            'password' => ['string', 'min:8', 'max:255', 'confirmed']
        ];
    }
}
