<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Enums\GuardEnums as Guard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Resources\Admin\AuthAdminUserResource;
use App\Models\Admin;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    use ApiResponseTrait;

    protected string $guard = Guard::Admin->value;

    public function __construct()
    {
        // $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validated();

        // Link https://medium.com/@parthpatel0516/laravel-multi-auth-using-guards-and-spatie-permission-with-example-api-authentication-4d5376f60d76
        // just make sure whenever you need to use attempt() or login(), and the driver is “token” or “passport” we need to set the driver as session. so,
        // in our example we are using passport driver and to set driver as session add this line
        config(['auth.guards.admin-api.driver' => 'session']);

        $user = Admin::where('email', $credentials['email'])->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Incorrect credentials.'],
            ]);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Incorrect credentials.'],
            ]);
        }
        if (!$user->status) {
            return $this->failure('Your account is inactive. Please contact the administrator.', 401);
        }


//        Auth::login($user);
//        $user = Auth::user();
        Auth::guard($this->guard)->login($user);
        $user = Auth::guard($this->guard)->user();
        $token = $user->createToken($this->guard . 'Token', ['check-admin']);

        return $this->success('Login Successful.', [
            'token' => $token->accessToken,
            'user' => new AuthAdminUserResource($user),
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth($this->guard)->user()->token()->revoke();
        return $this->success('Successfully logged out.');
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->success('Token Refreshed.', [
            'user' => new AuthAdminUserResource(Auth::guard($this->guard)->user()),
            'token' => Auth::guard($this->guard)->refresh(),
        ]);
    }

    public function user(Request $request): \Illuminate\Http\JsonResponse
    {
        abort_if(!$request->user()->tokenCan('check-admin'), 401, 'Unauthorized');
        $authUser = Auth::guard($this->guard)->user();
        $authUser->load('adminSetting');
        $user = new AuthAdminUserResource($authUser);
        return $this->success('User Details.', $user);
    }
}
