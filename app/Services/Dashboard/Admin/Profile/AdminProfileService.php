<?php

namespace App\Services\Dashboard\Admin\Profile;

use App\Exceptions\Custom\WrongPasswordException;

class AdminProfileService
{
    /**
     * Show admin profile
     */
    public function getAdminProfile(string $guard = 'api'): object
    {
        return auth($guard)->user();
    }

    /**
     * Update admin profile
     */
    public function updateAdminProfile(array $data, string $guard = 'api'): object
    {
        $admin = $this->getAdminProfile($guard);
        $admin->update($data);
        return $admin->fresh();
    }

    /**
     * Update Profile Password
     * @throws WrongPasswordException
     */
    public function updateProfilePassword(array $data, string $guard = 'api'): object
    {
        $admin = $this->getAdminProfile($guard);
        $admin->checkOldPassword($data['old_password']);
        $admin->update(['password' => $data['password']]);
        return $admin->fresh();
    }


    /**
     * Manipulate profile request
     */
    public function manipulateProfileRequest($request): array
    {
        $validated_data = $request->validated();
        $admin = $this->getAdminProfile();
        $additional_data = [];
        /**
         * Conditional Dependent on the business logic
         * IF the Admin Email changing requires verification
         * then comment the following if and handle the verification as you like
         */
        if (($request->isMethod('patch') || $request->isMethod('put')) && (isset($validated_data['email']) && $validated_data['email'] != $admin->email)) {
            $additional_data += ['email_verified_at' => now()];
        }
        return handleFullName($validated_data, $admin, $additional_data);
    }


}
