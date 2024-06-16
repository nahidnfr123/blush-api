<?php

namespace App\Http\Controllers\Api\Admin;

use App\Traits\ApiResponseTrait;
use App\Utils\AdminSidebar;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success('Success', []);
    }

    public function clearCache(): JsonResponse
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('optimize:clear');

        Cache::forget('roles');
        Cache::forget('permissions');
        Cache::forget('sidebar-items');

        return $this->success('Success');
    }

    public function sidebarItems(): JsonResponse
    {
        $sidebar = new AdminSidebar();
        return $this->success('Success', $sidebar->sideBarItems());
    }
}
