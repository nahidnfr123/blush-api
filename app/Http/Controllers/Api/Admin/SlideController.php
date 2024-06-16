<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlideRequest;
use App\Http\Requests\IdsRequest;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\PageManager\SlideService;
use App\Models\Slide;
use App\Traits\ApiResponseTrait;

class SlideController extends Controller
{
    use ApiResponseTrait;

    protected SlideService $slideService;
    protected TrashService $trashService;

    public function __construct(SlideService $slideService)
    {
        $this->slideService = $slideService;
        $this->trashService = new TrashService(new Slide());

        $module = 'slide';
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
        $slides = $this->slideService->getAll();
        return $this->success('Success', $slides);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlideRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $slide = $this->slideService->store($request);
            return $this->success('Home Slide created successfully', $slide);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slide $slide): \Illuminate\Http\JsonResponse
    {
        return $this->success('Success', $slide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SlideRequest $request, Slide $slide): \Illuminate\Http\JsonResponse
    {
        try {
            $slide = $this->slideService->update($request, $slide);
            return $this->success('Home Slide updated successfully', $slide);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slide $slide): \Illuminate\Http\JsonResponse
    {
        try {
            $slide->delete();
            return $this->success('Home Slide deleted successfully');
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

    public function restore(Slide $slide): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($slide);
    }

    public function bulkRestore(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkRestore($data['ids']);
    }

    public function forceDelete(Slide $slide): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($slide);
    }

    public function bulkForceDelete(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkForceDelete($data['ids']);
    }
}
