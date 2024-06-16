<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdsRequest;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Tag\TagResource;
use App\Http\Services\HelperServices\TrashService;
use App\Http\Services\TagService;
use App\Models\Tag;
use App\Traits\ApiResponseTrait;

class TagController extends Controller
{
    use ApiResponseTrait;

    protected TagService $tagService;
    protected TrashService $trashService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
        $this->trashService = new TrashService(new Tag());
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $tags = $this->tagService->getAll();
        return $this->success('Success', TagCollection::make($tags));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->tagService->store($request);
            return $this->success('Tag Created Successfully.', new TagResource($data));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): \Illuminate\Http\JsonResponse
    {
        $tag->load('products');
        return $this->success('Success', new TagResource($tag));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->tagService->update($request, $tag);
            return $this->success('Success', new TagResource($data));
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): \Illuminate\Http\JsonResponse
    {
        try {
            $tag->delete();
            return $this->success('Success');
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

    public function restore(Tag $tag): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->restore($tag);
    }

    public function bulkRestore(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkRestore($data['ids']);
    }

    public function forceDelete(Tag $tag): \Illuminate\Http\JsonResponse
    {
        return $this->trashService->forceDelete($tag);
    }

    public function bulkForceDelete(IdsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        return $this->trashService->bulkForceDelete($data['ids']);
    }
}
