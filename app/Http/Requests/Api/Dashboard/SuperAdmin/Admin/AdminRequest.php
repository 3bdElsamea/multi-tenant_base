<?php

namespace App\Http\Requests\Api\Dashboard\SuperAdmin\Admin;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class AdminRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $status = isset($this->admin) ? 'nullable' : 'required';
        $id = isset($this->admin) ? $this->admin->id : null;
        return [
            'first_name' => $status . '|string|max:255',
            'last_name' => $status . '|string|max:255',
            'email' => $status . '|email|unique:users,email,' . $id . ',id,user_type,admin',
            'password' => $status . '|string|min:8|max:255|confirmed',
        ];
    }
}
