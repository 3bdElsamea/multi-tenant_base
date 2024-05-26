<?php

namespace App\Http\Controllers\Api\Dashboard\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\General\Auth\GeneralLoginRequest;
use App\Http\Resources\Api\Dashboard\General\Auth\GeneralLoginResource;
use App\Services\Dashboard\SuperAdmin\Admin\AdminAuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AdminAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(GeneralLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated() + ["user_type" => "admin"];
        $user = $this->authService->adminLogin($credentials);
        return successResponse(__('auth.login.success'), new GeneralLoginResource($user));
    }

    public function logout(): JsonResponse
    {
        $this->authService->adminLogout();
        return successResponse(__('auth.logout.success'));
    }
}
