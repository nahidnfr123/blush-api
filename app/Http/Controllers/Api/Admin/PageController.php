<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdsRequest;
use App\Http\Requests\PageRequest;
use App\Http\Resources\PageManager\PageCollection;
use App\Http\Resources\PageManager\PageResource;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\PageManager\PageService;
use App\Models\Grid;
use App\Models\Page;
use App\Traits\ApiResponseTrait;

class PageController extends Controller
{
    use ApiResponseTrait;

    protected PageService $pageService;
    protected TrashService $trashService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->trashService = new TrashService(new Grid());

        $module = 'page';
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
        $pages = $this->pageService->getAll();
        return $this->success('Success', PageCollection::make($pages));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $page = $this->pageService->store($request);
            return $this->success('Page created successfully', new PageResource($page));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page): \Illuminate\Http\JsonResponse
    {
        return $this->success('Success', new PageResource($page));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page): \Illuminate\Http\JsonResponse
    {
        try {
            $page = $this->pageService->update($request, $page);
            return $this->success('Page updated successfully', new PageResource($page));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): \Illuminate\Http\JsonResponse
    {
        try {
            $page->delete();
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

    public function restore(Page $page): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($page);
    }

    public function bulkRestore(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkRestore($data['ids']);
    }

    public function forceDelete(Page $page): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($page);
    }

    public function bulkForceDelete(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkForceDelete($data['ids']);
    }
}
