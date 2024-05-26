<?php
$attributes = [
    'password' => ' حقل كلمة المرور',
    'email' => 'حقل البريد الإلكتروني',
    'phone' => 'حقل الهاتف',
    'phone_code' => 'حقل رمز الهاتف',
    'full_name' => 'حقل الاسم الكامل',
    'first_name' => 'حقل الاسم الأول',
    'last_name' => 'حقل الاسم الأخير',
    'old_password' => 'حقل كلمة المرور القديمة',
    'manager_data' => 'حقل بيانات المدير',
    'manager_data.email' => 'حقل بريد المدير',
    'manager_data.password' => 'حقل كلمة مرور المدير',
    'manager_data.full_name' => 'حقل الاسم الكامل للمدير',
    'is_active' => 'حقل النشاط',
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
    'confirmed' => ':attribute لا يتطابق مع التأكيد.',
    'required' => ':attribute مطلوب.',
    'unique' => ':attribute موجود مسبقاً.',
    'exists' => ':attribute غير صحيح.',
    'different' => ':attribute يجب أن يكون مختلفاً عن :other.',
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
