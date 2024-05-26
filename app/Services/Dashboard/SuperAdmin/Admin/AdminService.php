<?php

namespace App\Services\Dashboard\SuperAdmin\Admin;

use App\Models\User;

class AdminService
{
    /**
     * Create a new admin
     */
    public function createAdmin($data)
    {
        return User::create($data);
    }

    /**
     * Get all admins
     */
    public function getAllAdmins()
    {
        return User::where('user_type', 'admin')->paginate(10);
    }

    /**
     * Get admin by id
     */
    public function getTrashedAdminById($id)
    {
        return User::where('user_type', 'admin')->onlyTrashed()->findOrFail($id);
    }

    /**
     * Update admin
     */
    public function updateAdmin($admin, $data)
    {
        return $admin->update($data);
    }

    /**
     * Delete admin
     */
    public function deleteAdmin($admin)
    {
        return $admin->delete();
    }

    /**
     * restore admin
     */
    public function restoreAdmin($id)
    {
        $admin = User::onlyTrashed()->where('user_type', 'admin')->findOrFail($id);
        return $admin->restore();
    }

    /**
     * force delete admin
     */
    public function forceDeleteAdmin($id)
    {
        $admin = User::withTrashed()->where('user_type', 'admin')->findOrFail($id);
        return $admin->forceDelete();
    }

    /**
     * Get all trashed admins
     */
    public function getAllTrashedAdmins()
    {
        return User::where('user_type', 'admin')->onlyTrashed()->paginate(10);
    }

    /**
     * Manipulate admin Request
     */
    public function manipulateAdminRequest($request, $admin = null): array
    {
        $validated_data = $request->validated();
        $additions = [];
        if ($request->isMethod('post')) {
            $additions = ['user_type' => 'admin', 'email_verified_at' => now(), 'is_active' => 1];
        } /**
         * Conditional Dependent on the business logic
         * IF the Admin Email changing requires verification
         * then comment the following elseif and handle the verification as you like
         */
        elseif (($request->isMethod('patch') || $request->isMethod('put')) && (isset($validated_data['email']) && $validated_data['email'] != $admin->email)) {
            $additions = ['email_verified_at' => now()];
        }
        return handleFullName($validated_data, $admin, $additions);
    }
}
