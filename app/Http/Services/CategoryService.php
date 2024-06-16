<?php

namespace App\Http\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection|array
    {
        // ['id', 'name', 'icon', 'slug', 'parent_id', 'order', 'active', 'featured']
        $categoriesTree = Category::tree(null, true);
        $categories = Category::withCount('products')->trash()->get();
        return [
            'data' => [
                'tree' => $categoriesTree,
                'categories' => CategoryResource::collection($categories),
            ],
            'trashed_count' => Category::onlyTrashed()->count(),
        ];
    }

    public function store($request)
    {
        $data = $request->validated();
        return Category::create($data);
    }

    public function update($request, $category)
    {
        $data = $request->validated();
        $category->update($data);
        return $category;
    }
}
