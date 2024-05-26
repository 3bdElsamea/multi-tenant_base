<?php

namespace App\Services;

use App\Exceptions\Custom\InvalidCredentialsException;
use App\Exceptions\Custom\SomethingWentWrongException;
use Exception;
use Illuminate\Support\Arr;

class GeneralAuthService
{
    /**
     * General Login Service
     * @throws InvalidCredentialsException
     */
    public function login($credentials, $guard = 'api'): string
    {
        $token = auth($guard)->attempt($credentials);
        if (!$token) {
            throw new InvalidCredentialsException(__('auth.login.failed'), 401);
        }
        return $token;
    }

    /**
     * General Logout Service
     * @throws SomethingWentWrongException
     */

    public function logout($guard = 'api'): void
    {
        try {
            auth($guard)->logout();
        } catch (Exception $exception) {
            throw new SomethingWentWrongException(__('handler.something_went_wrong.logout'), 500);
        }
    }

    /**
     * General Forgot Password Service
     * @throws InvalidCredentialsException
     */
    public function forgotPassword($model, $credentials)
    {
        $user = $model::where($credentials)->first();
        if (!$user) {
            throw new InvalidCredentialsException(__('handler.not_found_email', ['email' => $credentials['email']]), 404);
        }
//        $user->sendPasswordResetNotification($user->createToken('Reset Password')->accessToken);  // to implement
        return $user->update(['reset_password_token' => 1111]);
    }

    /**
     * General Reset Password Service
     * @throws InvalidCredentialsException
     */
    public function resetPassword($model, $credentials)
    {
        $user = $model::where(Arr::except($credentials, ['password', 'password_confirmation']))->first();
        if (!$user) {
            throw new InvalidCredentialsException(__('handler.not_found_email', ['email' => $credentials['email']]), 404);
        }
        return $user->update(['reset_password_token' => null, 'password' => $credentials['password']]);
    }

}
