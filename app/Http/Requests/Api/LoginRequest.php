<?php

namespace App\Http\Requests\Api;

/**
 * Class LoginRequest
 *
 * @package App\Http\Requests\Api
 */
class LoginRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc|min:10|max:50',
            'password' => 'required|min:6',
        ];
    }
}
