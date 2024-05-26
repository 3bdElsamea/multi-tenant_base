<?php

namespace App\Http\Controllers\Api\Dashboard\SuperAdmin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\General\Auth\GeneralLoginRequest;
use App\Http\Resources\Api\Dashboard\General\Auth\GeneralLoginResource;
use App\Services\Dashboard\SuperAdmin\Admin\AdminAuthService;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
//    Constructor
    /**
     * @var \Illuminate\Contracts\Foundation\Application|Application|mixed
     */
    private $authService;

    public function __construct(AdminAuthService $authService)
    {
        $this->authService = $authService;
    }

//    Super Admin Login
    public function login(GeneralLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated() + ["user_type" => "super_admin"];
        $user = $this->authService->adminLogin($credentials);
        return successResponse(__('auth.login.success'), new GeneralLoginResource($user));
    }

//    Super Admin Logout
    public function logout(): JsonResponse
    {
        $this->authService->adminLogout();
        return successResponse(__('auth.logout.success'));
    }
}
