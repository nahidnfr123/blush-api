<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\HelperServices\OrderService;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class ArrangeOrderController extends Controller
{
    use ApiResponseTrait;

    public function updateOrder(Request $request, $model_name): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer'
        ]);

        try {
            $model_name = ucfirst($model_name);
            $model = "App\\Models\\$model_name";
            $model = app($model);
            $orderService = new OrderService($model);
            $orderService->updateOrder($request->order);
            return $this->success('Order updated successfully');
        } catch (Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
    }
}
