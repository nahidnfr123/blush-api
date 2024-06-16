<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GridRequest;
use App\Http\Requests\IdsRequest;
use App\Http\Resources\PageManager\GridCollection;
use App\Http\Resources\PageManager\GridResource;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\PageManager\GridService;
use App\Models\Grid;
use App\Traits\ApiResponseTrait;

class GridController extends Controller
{
    use ApiResponseTrait;

    protected GridService $gridService;
    protected TrashService $trashService;

    public function __construct(GridService $gridService)
    {
        $this->gridService = $gridService;
        $this->trashService = new TrashService(new Grid());

        $module = 'grid';
        $this->middleware(["permission:view $module|create $module|update $module|delete $module"], ['only' => ['index', 'show']]);
        $this->middleware(["permission:create $module"], ['only' => ['store']]);
        $this->middleware(["permission:update $module"], ['only' => ['update']]);
        $this->middleware(["permission:delete $module"], ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware(["permission:restore $module"], ['only' => ['restore', 'bulkRestore']]);
        $this->middleware(["permission:force delete $module"], ['only' => ['forceDelete', 'bulkForceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $grids = $this->gridService->getAll();
        return $this->success('Success', GridCollection::make($grids));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GridRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $grid = $this->gridService->store($request);
            return $this->success('Grid created successfully', new GridResource($grid));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Grid $grid): \Illuminate\Http\JsonResponse
    {
        $grid->load('gridItems');
        return $this->success('Success', new GridResource($grid));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GridRequest $request, Grid $grid): \Illuminate\Http\JsonResponse
    {
        try {
            $grid = $this->gridService->update($request, $grid);
            return $this->success('Grid updated successfully', new GridResource($grid));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grid $grid): \Illuminate\Http\JsonResponse
    {
        try {
            $grid->delete();
            return $this->success('deleted successfully');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }


    // Additional methods //
    public function bulkDestroy(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkDelete($data['ids']);
    }

    public function restore(Grid $grid): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($grid);
    }

    public function bulkRestore(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkRestore($data['ids']);
    }

    public function forceDelete(Grid $grid): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($grid);
    }

    public function bulkForceDelete(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkForceDelete($data['ids']);
    }
}
