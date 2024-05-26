<?php
$attributes = [
    'password' => 'Password Field',
    'email' => 'Email Field',
    'phone' => 'Phone Field',
    'phone_code' => 'Phone Code Field',
    'full_name' => 'Full Name Field',
    'first_name' => 'First Name Field',
    'last_name' => 'Last Name Field',
    'old_password' => 'Old Password Field',
    'manager_data' => 'Manager Data Field',
    'manager_data.email' => 'Manager Email Field',
    'manager_data.password' => 'Manager Password Field',
    'manager_data.full_name' => 'Manager Full Name Field',
    'is_active' => 'Is Active Field',
];
return [
    /*
   |--------------------------------------------------------------------------
   | Validation Language Lines
   |--------------------------------------------------------------------------
   |
   | The following language lines contain the default error messages used by
   | the validator class. Some of these rules have multiple versions such
   | as the size rules. Feel free to tweak each of these messages here.
   |
   */
    'confirmed' => 'The :attribute confirmation does not match.',
    'required' => 'The :attribute field is required.',
    'unique' => 'The :attribute has already been taken.',
    'exists' => 'The selected :attribute is invalid.',
    'different' => 'The :attribute and :other must be different.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [],

    /*
       |--------------------------------------------------------------------------
       | Custom Validation Attributes
       |--------------------------------------------------------------------------
       |
       | The following language lines are used to swap our attribute placeholder
       | with something more reader friendly such as "E-Mail Address" instead
       | of "email". This simply helps us make our message more expressive.
       |
       */
    'attributes' => $attributes,
];
