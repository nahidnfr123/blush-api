<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Services\CategoryService;
use App\Http\Services\HelperServices\TrashService;
use App\Models\Category;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    protected CategoryService $categoryService;
    protected TrashService $trashService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->trashService = new TrashService(new Category());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = $this->categoryService->getAll();
        return $this->success('Success', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->categoryService->store($request);
            return $this->success('Category created successfully', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): \Illuminate\Http\JsonResponse
    {
        return $this->success('Success', new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->categoryService->update($request, $category);
            return $this->success('Category updated successfully', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        try {
            $category->delete();
            return $this->success('Category deleted successfully');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function bulkDestroy(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkDelete(request('ids'));
    }

    public function restore(Category $category): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($category);
    }

    public function bulkRestore(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkRestore(request('ids'));
    }

    public function forceDelete(Category $category): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($category);
    }

    public function bulkForceDelete(): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->bulkForceDelete(request('ids'));
    }
}
