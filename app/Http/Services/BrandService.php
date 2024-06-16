<?php

namespace App\Http\Services;

use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;

class BrandService
{
    public function getAll(): BrandCollection
    {
        // request() order_by, order, per_page, query, active, featured, trash
        $brands = Brand::withCount('products')
            ->trash()
            ->search(request('query'), ['%name', '%slug'])
            ->search(request('active'), ['active'])
            ->search(request('featured'), ['featured'])
            ->latest()
            ->orderBy(request('order_by', 'order'), request('order', 'ASC'))
            ->paginate(perPage());

        return BrandCollection::make($brands);
    }

    public function store($request): BrandResource
    {
        $data = $request->validated();
        unset($data['image'], $data['logo']);

        $name = str_replace(' ', '_', $data['name']);
        $data['active'] = $data['active'] ?? 0;
        $data['featured'] = $data['featured'] ?? 0;

        if ($request->hasFile('logo')) {
            $data['logo'] = uploadFile($request->logo, 'images/brand', $name);
        }

        if ($request->hasFile('image')) {
            $data['image'] = uploadFile($request->image, 'images/brand', $name);
        }

        if ($request->logo_link && file_exists(storage_path('app/public/' . $request->logo_link))) {
            $data['logo'] = $request->logo_link;
        }
        if ($request->image_link && file_exists(storage_path('app/public/' . $request->image_link))) {
            $data['image'] = $request->image_link;
        }

        $brand = new Brand();
        $brand->fill($data);
        $brand->save();

        return new BrandResource($brand);
    }

    public function update($request, $brand): BrandResource
    {
        $data = $request->validated();
        unset($data['image'], $data['logo']);

        $name = str_replace(' ', '_', $data['name']);
        $data['active'] = $data['active'] ?? 0;
        $data['featured'] = $data['featured'] ?? 0;

        if ($request->hasFile('logo')) {
            $data['logo'] = uploadFile($request->logo, 'images/brand', $name);
            if ($data['logo'] && $brand->logo) deleteFile($brand->logo);
        }

        if ($request->hasFile('image')) {
            $data['image'] = uploadFile($request->image, 'images/brand', $name);
            if ($data['image'] && $brand->image) deleteFile($brand->image);
        }

        $brand->fill($data);
        $brand->save();

        return new BrandResource($brand);
    }
}
