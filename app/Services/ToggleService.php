<?php

namespace App\Services;

class ToggleService
{
    public function toggle($model, $field)
    {
        $model->$field = !$model->$field;
        $model->save();
        return $model->fresh();
    }

//    change active status of a model dependencies
    public function toggleDependencies($model, $field, $dependencies)
    {
        /**
         * this is just an idea the implementation should be corrected
         */
        foreach ($dependencies as $dependency) {
            $dependency->$field = $model->$field;
            $dependency->save();
        }
        return $model;
    }
}
