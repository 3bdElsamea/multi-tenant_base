<?php

namespace App\Http\Controllers\Api\Dashboard\SuperAdmin\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\SuperAdmin\Admin\AdminRequest;
use App\Http\Resources\Api\Dashboard\SuperAdmin\Admin\AdminResource;
use App\Http\Resources\Api\Dashboard\SuperAdmin\Admin\DetailedAdminResource;
use App\Models\User;
use App\Services\Dashboard\SuperAdmin\Admin\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
//    Constructor
    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

//    Index
    public function index()
    {
        $admins = $this->adminService->getAllAdmins();
        return successResponse('', AdminResource::collection($admins));
    }

//    All Trashed
    public function trashed(): JsonResponse
    {
        $admins = $this->adminService->getAllTrashedAdmins();
        return successResponse('', AdminResource::collection($admins));
    }

//    Show
    public function show(User $admin): JsonResponse
    {
        return successResponse('', new DetailedAdminResource($admin));
    }

//    Show Trashed
    public function showTrashed($id): JsonResponse
    {
        $admin = $this->adminService->getTrashedAdminById($id);
        return successResponse('', new DetailedAdminResource($admin));
    }

//    Store
    public function store(AdminRequest $request): JsonResponse
    {
        $data = $this->adminService->manipulateAdminRequest($request);
        $admin = $this->adminService->createAdmin($data);
        return successResponse(__('dashboard.cruds.created', ['model' => __('variables.admin')]), new AdminResource($admin));
    }

//    Update
    public function update(AdminRequest $request, User $admin): JsonResponse
    {
        $data = $this->adminService->manipulateAdminRequest($request, $admin);
        $this->adminService->updateAdmin($admin, $data);
        return successResponse(__('dashboard.cruds.updated', ['model' => __('variables.admin')]), new AdminResource($admin));
    }

//    Destroy
    public function destroy(User $admin): JsonResponse
    {
        $this->adminService->deleteAdmin($admin);
        return successResponse(__('dashboard.cruds.deleted', ['model' => __('variables.admin')]));
    }

//    Restore
    public function restore($id): JsonResponse
    {
        $this->adminService->restoreAdmin($id);
        return successResponse(__('dashboard.cruds.restored', ['model' => __('variables.admin')]));
    }

//    Force Delete
    public function forceDelete($id): JsonResponse
    {
        $this->adminService->forceDeleteAdmin($id);
        return successResponse(__('dashboard.cruds.force_deleted', ['model' => __('variables.admin')]));
    }
}
