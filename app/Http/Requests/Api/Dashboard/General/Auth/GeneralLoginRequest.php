<?php

namespace App\Http\Requests\Api\Dashboard\General\Auth;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class GeneralLoginRequest extends ApiMasterRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }
}
