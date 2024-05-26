<?php

namespace App\Http\Controllers\Api\Dashboard\Admin\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Admin\Business\BusinessRequest;
use App\Http\Resources\Api\Dashboard\Admin\Business\IndexBusinessResource;
use App\Http\Resources\Api\Dashboard\Admin\Business\ShowBusinessResource;
use App\Models\Business;
use App\Services\Dashboard\Admin\Business\BusinessService;
use App\Services\Dashboard\Business\BusinessAdmin\BusinessAdminService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{
    private BusinessService $businessService;
    private BusinessAdminService $businessAdminService;

    public function __construct(BusinessService $businessService, BusinessAdminService $businessAdminService)
    {
        $this->businessService = $businessService;
        $this->businessAdminService = $businessAdminService;
    }

    public function index(): JsonResponse
    {
        $businesses = $this->businessService->getAllBusinesses();
        return successResponse('', IndexBusinessResource::collection($businesses));
    }

    public function trashed(): JsonResponse
    {
        $businesses = $this->businessService->showAllTrashedBusinesses();
        return successResponse('', IndexBusinessResource::collection($businesses));
    }

    public function show(Business $business): JsonResponse
    {
        return successResponse('', new ShowBusinessResource($business));
    }

    public function showTrashed($id): JsonResponse
    {
        $business = $this->businessService->showTrashedBusinesses($id);
        return successResponse('', new ShowBusinessResource($business));
    }

    public function store(BusinessRequest $request): JsonResponse
    {
        $business_data = Arr::except($request->validated(), 'manager_data');
//        dd($business_data);
        $business = $this->businessService->createBusiness($business_data);
        $manager_data = $request->validated()['manager_data'] + ['user_type' => 'business_manager', 'business_id' => $business->id,];
        $this->businessAdminService->createBusinessAdmin($manager_data);
        return successResponse(__('dashboard.cruds.created', ['model' => __('variables.business')]), new ShowBusinessResource($business));
    }

    public function update(BusinessRequest $request, Business $business): JsonResponse
    {
        $business = $this->businessService->updateBusiness($business, $request->validated());
        return successResponse(__('dashboard.cruds.updated', ['model' => __('variables.business')]), new ShowBusinessResource($business));
    }

    public function destroy(Business $business): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->businessService->updateBusiness($business, ['is_active' => 0]);
            $this->businessService->deleteBusiness($business);
            DB::commit();
            return successResponse(__('dashboard.cruds.deleted', ['model' => __('variables.business')]));
        } catch (Exception $e) {
            DB::rollBack();
            return failResponse(400, __('handler.something_went_wrong.delete'));
        }
    }

    public function restore($id): JsonResponse
    {
        $business = $this->businessService->showTrashedBusinesses($id);
        $this->businessService->restoreBusiness($business);
        return successResponse(__('dashboard.cruds.restored', ['model' => __('variables.business')]));
    }

    public function forceDelete($id): JsonResponse
    {
        $this->businessService->forceDeleteBusiness($id);
        return successResponse(__('dashboard.cruds.force_deleted', ['model' => __('variables.business')]));
    }

}
