<?php

namespace App\Http\Requests\Api\Dashboard\Admin\Profile;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateAdminPasswordRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|string|min:8',
            'password' => 'required|different:old_password|string|min:8|confirmed',
        ];
    }
}
