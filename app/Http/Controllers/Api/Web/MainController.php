<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PageManager\GridResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Grid;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class MainController extends Controller
{
    use ApiResponseTrait;

    public function categories(): \Illuminate\Http\JsonResponse
    {
        // Generate Tree For all Categories ...
        $activeCategories = Category::active()->select('id', 'name', 'name_bn', 'slug', 'icon', 'image', 'active', 'featured', 'parent_id')->get();
        $rootCategories = $activeCategories->whereNull('parent_id');
        $model = new Category();
        $model->formatTree($rootCategories, $activeCategories);
        $tree = $rootCategories->values();

        // Flat featured categories ...
        $featuredCategories = Category::active()->featured()->get();

        return $this->success('Success', [
            'active' => $tree,
            'featured' => CategoryResource::collection($featuredCategories),
        ]);
    }

    public function products(): \Illuminate\Http\JsonResponse
    {
        $products = Product::visible()->latest()->get();
        if (request('type')) {
            // get random 10 products..
            $products = $products->random(10);
        }
        return $this->success('Success', $products);
    }

    public function getGrid(): \Illuminate\Http\JsonResponse
    {
        $query = Grid::query();
        $query->with('gridItems');
        if (request('slug')) {
            $query->where('slug', request('slug'));
        }
        $grid = $query->active()->first();
        return $this->success('Success', new GridResource($grid));
    }

    public function getCategories(): \Illuminate\Http\JsonResponse
    {
        $query = Category::query();
        if (request('for-you')) {

        }
        if (request('trending')) {

        }
        if (request('featured')) {
            $query->featured();
        }
        if (request('product_count')) {
            $query->withCount('products');
        }
        $categories = $query->active()->ordered()->get();
        return $this->success('Success', $categories);
    }

    public function getBrands(): \Illuminate\Http\JsonResponse
    {
        $query = Brand::query();
        if (request('featured')) {
            $query->featured();
        }
        if (request('product_count')) {
            $query->withCount('products');
        }
        $brands = $query->active()->ordered()->get();
        return $this->success('Success', $brands);
    }

    public function getProducts(): \Illuminate\Http\JsonResponse
    {
        $query = Product::query();
        if (request('featured')) {
            $query->featured();
        }
        if (request('in_stock')) {
            $query->inStock();
        }
        if (request('category')) {
            $query->whereHas('categories', function ($q) {
                $q->where('slug', request('category'));
            });
        }
        if (request('brand')) {
            $query->where('brand_id', Brand::where('slug', request('brand'))->firstOrFail()->id);
        }
        $products = $query->visible()->active()->ordered()->get();
        return $this->success('Success', $products);
    }
}
