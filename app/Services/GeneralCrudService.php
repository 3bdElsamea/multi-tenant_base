<?php

namespace App\Services;

class GeneralCrudService
{

    /**
     * Get all
     */
    public function getAll($model)
    {
        return $model::all();
    }

    /**
     * Create
     */
    public function create($model, $data)
    {
        return $model::create($data);
    }

}
