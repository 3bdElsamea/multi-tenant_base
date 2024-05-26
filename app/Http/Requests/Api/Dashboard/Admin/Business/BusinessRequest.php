<?php

namespace App\Http\Requests\Api\Dashboard\Admin\Business;

use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class BusinessRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $status = isset($this->business) ? 'nullable' : 'required';
        $rules = [
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        ];

        if ($this->isMethod('post')) {
            $rules['is_active'] = 'nullable|in:0,1';
            $rules['manager_data'] = 'required|array';
            $rules['manager_data.email'] = 'required|email|unique:users,email,NULL,id,user_type,business_manager';
            $rules['manager_data.password'] = 'required|string|min:6';
            $rules['manager_data.full_name'] = 'required|string|min:3|max:255';
        }

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.name'] = $status . '|string|min:3|max:255';
            $rules[$locale . '.description'] = 'nullable|string|min:3|max:255';
        }
        return $rules;
    }
}
