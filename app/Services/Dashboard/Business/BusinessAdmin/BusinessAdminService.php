<?php

namespace App\Services\Dashboard\Business\BusinessAdmin;

use App\Models\User;

class BusinessAdminService
{
    /**
     * Create Business Admin
     */
    public function createBusinessAdmin(array $data)
    {
        $data = array_merge($data, ['is_active' => 1, 'email_verified_at' => now()]);
        return User::create($data);
    }
}
