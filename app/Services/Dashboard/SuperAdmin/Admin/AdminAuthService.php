<?php

namespace App\Services\Dashboard\SuperAdmin\Admin;

use App\Exceptions\Custom\InvalidCredentialsException;
use App\Services\GeneralAuthService;

class AdminAuthService extends GeneralAuthService
{
    /**
     * Admin Login Service
     * @throws InvalidCredentialsException
     */
    public function adminLogin($credentials)
    {
        $token = parent::login($credentials);
        $user = auth('api')->user();
        $user->token = $token;
        return $user;
    }

    /**
     * Admin Logout Service
     */
    public function adminLogout($guard = 'api')
    {
        return parent::logout($guard);
    }

    /**
     * Admin Forgot Password Service
     * @throws InvalidCredentialsException
     */
//    public function adminForgotPassword($credentials)
//    {
//        return parent::forgotPassword(User::class, $credentials);
//    }

}
