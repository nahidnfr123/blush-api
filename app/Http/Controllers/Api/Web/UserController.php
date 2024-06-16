<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function me(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new UserResource($request->user());
        return $this->success('User Index',$user);
    }
}
