<?php

namespace App\Http\Requests\Api\Dashboard\Admin\Profile;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class AdminProfileRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . auth()->id() . ',id,user_type,admin', // if there is a verification , change the logic
            'avatar' => 'nullable|image',
        ];
    }
}
