<?php

namespace App\Http\Controllers\Api\Dashboard\Admin\Profile;

use App\Exceptions\Custom\WrongPasswordException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Admin\Profile\AdminProfileRequest;
use App\Http\Requests\Api\Dashboard\Admin\Profile\UpdateAdminPasswordRequest;
use App\Http\Resources\Api\Dashboard\Admin\Profile\AdminProfileResource;
use App\Services\Dashboard\Admin\Profile\AdminProfileService;
use App\Services\Dashboard\SuperAdmin\Admin\AdminAuthService;
use App\Services\PhoneWithVerificationService as PhoneService;
use Illuminate\Http\JsonResponse;

class AdminProfileController extends Controller
{
    private AdminProfileService $adminProfileService;
    private AdminAuthService $adminAuthService;
//    private PhoneService $phoneService;

    /**
     * Constructor
     */
    public function __construct(AdminProfileService $adminProfileService, PhoneService $phoneService, AdminAuthService $adminAuthService)
    {
        $this->adminProfileService = $adminProfileService;
        $this->phoneService = $phoneService;
        $this->adminAuthService = $adminAuthService;
    }

    /**
     * Show admin profile
     */
    public function profile(): JsonResponse
    {
        $admin = $this->adminProfileService->getAdminProfile();
        return successResponse('', new AdminProfileResource($admin));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(AdminProfileRequest $request): JsonResponse
    {
        $data = $this->adminProfileService->manipulateProfileRequest($request);
        $admin = $this->adminProfileService->updateAdminProfile($data);
        return successResponse(__('dashboard.cruds.updated', ['model' => __('variables.profile')]), new AdminProfileResource($admin));
    }


    /**
     * Update Profile Password
     * @throws WrongPasswordException
     */
    public function updateProfilePassword(UpdateAdminPasswordRequest $request): JsonResponse
    {
        $admin = $this->adminProfileService->updateProfilePassword($request->validated());
        $this->adminAuthService->adminLogout();
        return successResponse(__('dashboard.profile.password_updated'));
    }
}
