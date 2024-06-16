<?php

namespace App\Http\Services\HelperServices;

use App\Traits\ApiResponseTrait;
use Exception;

class TrashService
{
    use ApiResponseTrait;

    private mixed $model;
    private string $model_name;

    public function __construct($model = null)
    {
        $this->model = $model;
        if ($this->model) {
            $this->model_name = class_basename($this->model);
        }
    }

    public function bulkDelete($ids): \Illuminate\Http\JsonResponse
    {
        //        if ($ids != '' && is_string($ids)) {
//            $ids = explode(',', $ids);
//        }

        try {
            if ($this->model && count($ids) > 0) {
                $this->model->destroy($ids);
            } else {
                throw new Exception('Model or ids not found');
            }
            return $this->success(ucfirst($this->model_name) . 's deleted successfully!');
        } catch (Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function restore($model): \Illuminate\Http\JsonResponse
    {
        try {
            $model->restore();
            return $this->success(ucfirst($this->model_name) . ' restored successfully!', $model);
        } catch (Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function bulkRestore($ids): \Illuminate\Http\JsonResponse
    {
        //        if ($ids != '' && is_string($ids)) {
//            $ids = explode(',', $ids);
//        }

        try {
            if ($this->model && count($ids) > 0) {
                $this->model->withTrashed()->whereIn('id', $ids)->restore();
            } else {
                throw new Exception('Model or ids not found');
            }
            return $this->success(ucfirst($this->model_name) . 's restored successfully!');
        } catch (Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function forceDelete($model): \Illuminate\Http\JsonResponse
    {
        try {
            $model->forceDelete();
            return $this->success(ucfirst($this->model_name) . ' force deleted successfully!');
        } catch (Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function bulkForceDelete($ids): \Illuminate\Http\JsonResponse
    {
//        if ($ids != '' && is_string($ids)) {
//            $ids = explode(',', $ids);
//        }

        try {
            if ($this->model && count($ids) > 0) {
                $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
            } else {
                throw new Exception('Model or ids not found');
            }
            return $this->success(ucfirst($this->model_name) . 's force deleted successfully!');
        } catch (Exception $e) {
            return $this->failure($e->getMessage());
        }
    }
}
