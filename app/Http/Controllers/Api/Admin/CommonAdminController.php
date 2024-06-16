<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\GuardEnums;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\WarrantyTypeResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use App\Models\VariantAttribute;
use App\Models\WarrantyType;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommonAdminController extends Controller
{
    use ApiResponseTrait;

    public function categories(): \Illuminate\Http\JsonResponse
    {
        $data = Category::query();
        $allCategories = $data->orderBy('order')
            ->select('id', 'name', 'slug', 'parent_id')
            ->get();

        $rootCategories = $allCategories->whereNull('parent_id');
        self::formatTree($rootCategories, $allCategories);

        $tree = $rootCategories->values();
        return $this->success('Success', [
            'tree' => $tree,
            'flat' => $allCategories,
        ]);
    }

    private static function formatTree($categories, $allCategories): void
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('parent_id', $category->id)->values();
            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }

    public function productFormData(): \Illuminate\Http\JsonResponse
    {
        $user = auth(GuardEnums::Admin->value)->user();
        $warrantyTypes = WarrantyType::select('id', 'name')->get();
        if ($user->can('view variant attribute')) {
            $variants = [
                'attributes' => [],
                'options' => [],
            ];
            $variantAttributes = VariantAttribute::with('variantAttributeValues')->get();
            foreach ($variantAttributes as $attribute) {
                $variants['attributes'][] = ['id' => $attribute->id, 'name' => $attribute->name,];
                foreach ($attribute->variantAttributeValues as $option) {
                    $variants['options'][] = [
                        'id' => $option->id,
                        'attribute_id' => $attribute->id,
                        'attribute_name' => $attribute->name,
                        'value' => $option->value,
                    ];
                }
            }
        } else {
            $variants = [];
        }

        $tags = $user->can('view tag') ? Tag::select('id', 'name', 'slug')->get() : [];
        $brands = $user->can('view brand') ? Brand::select('id', 'name', 'slug')->get() : [];
        $categoryTree = $user->can('view category') ? Category::tree(null, false) : [];
        $categories = $user->can('view category') ? Category::select('id', 'name', 'slug', 'parent_id', 'order')->get() : [];

//        return Cache::rememberForever('product-form-data', function () use ($brands, $categoryTree, $categories, $tags, $warrantyTypes, $variants) {
        return $this->success('Success', [
            'brands' => $brands,
            'categoryTree' => $categoryTree,
            'categories' => $categories,
            'tags' => $tags,
            'warrantyTypes' => $warrantyTypes,
            'variants' => $variants,
        ]);
//        });
    }
}
