<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function success($message, $data = null, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function failure($message, $status = 422, $errors = []): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];
        if (count($errors)) $response['errors'] = $errors;
        return response()->json($response, $status);
    }
}
