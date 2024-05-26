<?php

namespace App\Services\Dashboard\Admin\Business;

use App\Models\Business;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BusinessService
{
    /**
     * Get all businesses
     */
    public function getAllBusinesses()
    {
        return Business::paginate(10);

    }

    /**
     * Create a new business
     */
    public function createBusiness($data)
    {
        return Business::create($data);
    }

    /**
     * Update a business
     */
    public function updateBusiness($business, $data)
    {
        $business->update($data);
        return $business->fresh();
    }

    /**
     * Delete a business
     */
    public function deleteBusiness($business)
    {
        return $business->delete();
    }

    /**
     * Show all trashed businesses
     */
    public function showAllTrashedBusinesses(): LengthAwarePaginator
    {
        return Business::onlyTrashed()->paginate(10);
    }

    /**
     * Show trashed businesses
     */
    public function showTrashedBusinesses($id)
    {
        return Business::trashedById($id)->first();
    }


    /**
     * Restore a business
     */
    public function restoreBusiness($business)
    {
        return $business->restore();
    }

    /**
     * Force delete a business
     */
    public function forceDeleteBusiness($id)
    {
        return Business::withTrashed()->where('id', $id)->forceDelete();
    }

}
