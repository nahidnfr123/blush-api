<?php

namespace App\Http\Services;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductVariant;
use App\Models\Tag;
use App\Models\VariantAttribute;
use App\Models\VariantAttributeValue;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProductService
{
    public function getAll()
    {
        // request() order_by, order, per_page, query trash
        return Product::trash()
            ->search(request('query'), ['%name', '%slug'])
            ->orderBy(request('order_by', 'created_at'), request('order', 'ASC'))
            ->paginate(perPage());
    }

    public function store($request): Product
    {
        $data = $request->validated();
        $name = str_replace(' ', '_', $data['name']);

        if (isset($data['brand'])) {
            $brand = Brand::updateOrCreate(['name' => $data['brand']]);
            $data['brand_id'] = $brand->id;
            unset($data['brand']);
        }

        if (isset($data['tags'])) {
            $tags = explode(',', $data['tags']);
            unset($data['tags']);

            $tagIds = [];
            foreach ($tags as $tag) {
                $tagIds[] = Tag::updateOrCreate(['name' => $tag], ['name' => $tag])->id;
            }
            $data['tag_ids'] = $tagIds;
        }

        if (!isset($data['published_at'])) {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = date('Y-m-d', strtotime($data['published_at']));
        }

        if ($request->has('thumbnail_link')) {
            $data['thumbnail'] = $data['thumbnail_link'];
        } else if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = uploadFile($request->thumbnail, 'images/brand', $name);
        }

        if (!empty($data['discount_duration'])) {
            $startDate = explode(',', $data['discount_duration'])[0];
            $endDate = explode(',', $data['discount_duration'])[1];
            $data['discount_start_at'] = date('Y-m-d', strtotime($startDate));
            $data['discount_end_at'] = date('Y-m-d', strtotime($endDate));
        }

        if (isset($data['discounted_price']) && isset($data['original_price'])) {
            $data['discount_percentage'] = ($data['original_price'] - $data['discounted_price']) / $data['original_price'] * 100;
        }

        if (isset($data['discount_percentage']) && isset($data['original_price'])) {
            $data['discounted_price'] = $data['original_price'] - ($data['original_price'] * $data['discount_percentage'] / 100);
        }

        if (isset($data['draft']) && $data['draft']) {
            $data['draft'] = true;
        }

        // Create Product ...
        $product = new Product();
        $product->fill($data);
        $product->save();

        // Create Product Details ...
        $data['product_id'] = $product->id;
        $productDetail = new ProductDetail();
        $productDetail->fill($data);
        $productDetail->save();

        // Link Categories ...
        if (isset($data['category_ids'])) {
            $product->categories()->sync($data['category_ids']);
        }

        // Create And Link Tags ...
        if (isset($data['tag_ids'])) {
            $product->tags()->sync($data['tag_ids']);
        }

        // Product Variants ...
        if (isset($data['has_variant']) && $data['has_variant']) {
            $variants = $data['variants'];

            foreach ($variants as $key => $variant) {
                $variant['featured'] = (isset($data['featured_variant_index']) && $data['featured_variant_index'] == $key);

                $variant['product_id'] = $product->id;

                $attributes = $variant['attributes'];
                $variant['name'] = '';
                $variant['value'] = '';
                $skuCode = '';
                $attributesCount = count($attributes);
                $attrValueIds = [];
                foreach ($attributes as $a => $attribute) {
                    $variant['name'] .= $attribute['name'] . ($a !== $attributesCount ? '-' : '');
                    $variant['value'] .= $attribute['value'] . ($a !== $attributesCount ? '-' : '');

                    $attr = VariantAttribute::updateOrCreate(['name' => $attribute['name'],]);
                    $attr->variantAttributeValues()->updateOrCreate(['value' => $attribute['value'],]);
                    $skuCode .= $attribute['value'] . ($a !== $attributesCount ? '-' : '');
                    $attrValueIds[] = VariantAttributeValue::where('value', $attribute['value'])->first()->id;
                }
                $variant['sku_code'] = $skuCode;

                $productVariant = new ProductVariant();
                $productVariant->fill($variant);
                $productVariant->save();

                if (isset($variant['images']) && count($variant['images'])) {
                    foreach ($variant['images'] as $image) {
                        try {
                            $productVariant->addMedia('storage/' . $image)
                                ->preservingOriginal()
                                ->toMediaCollection('productVariants');
                            deleteFile($image);
                        } catch (FileDoesNotExist|FileIsTooBig $e) {
                            Log::info($e);
                        }
                    }
                }

                Log::info($variants);

                // Link Variant Attributes ...
                $productVariant->productVariantValues()->sync($attrValueIds);
            }
        }

        // Upload Images in ProductObserver ...
        if (request()->has('images')) {
            foreach (request()->images as $image) {
                try {
                    $product->addMedia('storage/' . $image)
                        ->preservingOriginal()
                        ->toMediaCollection('products');
                    deleteFile($image);
                } catch (FileDoesNotExist|FileIsTooBig $e) {
                    Log::info($e);
                }
            }
        }

        return $product;
    }

    public function update($request, $product): Product
    {
        $data = $request->validated();
        $name = str_replace(' ', '_', $data['name']);

        if (isset($data['brand'])) {
            $brand = Brand::updateOrCreate(['name' => $data['brand']]);
            $data['brand_id'] = $brand->id;
            unset($data['brand']);
        }

        if (isset($data['tags'])) {
            $tags = explode(',', $data['tags']);
            unset($data['tags']);

            $tagIds = [];
            foreach ($tags as $tag) {
                $tagIds[] = Tag::updateOrCreate(['name' => $tag], ['name' => $tag])->id;
            }
            $data['tag_ids'] = $tagIds;
        }

        if (!isset($data['published_at'])) {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = date('Y-m-d', strtotime($data['published_at']));
        }

        if ($request->has('thumbnail_link')) {
            $data['thumbnail'] = $data['thumbnail_link'];
        } else if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = uploadFile($request->thumbnail, 'images/brand', $name);
        }

        if (!empty($data['discount_duration'])) {
            $startDate = explode(',', $data['discount_duration'])[0];
            $endDate = explode(',', $data['discount_duration'])[1];
            $data['discount_start_at'] = date('Y-m-d', strtotime($startDate));
            $data['discount_end_at'] = date('Y-m-d', strtotime($endDate));
        }

        if (isset($data['discounted_price']) && isset($data['original_price'])) {
            $data['discount_percentage'] = ($data['original_price'] - $data['discounted_price']) / $data['original_price'] * 100;
        }

        if (isset($data['discount_percentage']) && isset($data['original_price'])) {
            $data['discounted_price'] = $data['original_price'] - ($data['original_price'] * $data['discount_percentage'] / 100);
        }

        // Create Product ...
        $product->fill($data);
        $product->save();

        // Create Product Details ...
        $data['product_id'] = $product->id;
        $product->productDetail->fill($data)->save();

        // Link Categories ...
        if (isset($data['category_ids'])) {
            $product->categories()->sync($data['category_ids']);
        }

        // Create And Link Tags ...
        if (isset($data['tag_ids'])) {
            $product->tags()->sync($data['tag_ids']);
        }

        // Product Variants ...
        if (isset($data['has_variant']) && $data['has_variant']) {
            $variants = $data['variants'];

            foreach ($variants as $key => $variant) {
                $variant['featured'] = (isset($data['featured_variant_index']) && $data['featured_variant_index'] == $key);

                $variant['product_id'] = $product->id;

                $attributes = $variant['attributes'];
                $variant['name'] = '';
                $variant['value'] = '';
                $skuCode = '';
                $attributesCount = count($attributes);
                $attrValueIds = [];
                foreach ($attributes as $a => $attribute) {
                    $variant['name'] .= $attribute['name'] . ($a !== $attributesCount ? '-' : '');
                    $variant['value'] .= $attribute['value'] . ($a !== $attributesCount ? '-' : '');

                    $attr = VariantAttribute::updateOrCreate(['name' => $attribute['name'],]);
                    $attr->variantAttributeValues()->updateOrCreate(['value' => $attribute['value'],]);
                    $skuCode .= $attribute['value'] . ($a !== $attributesCount ? '-' : '');
                    $attrValueIds[] = VariantAttributeValue::where('value', $attribute['value'])->first()->id;
                }
                $variant['sku_code'] = $skuCode;

//                $productVariant = new ProductVariant();
//                $productVariant->fill($variant);
//                $productVariant->save();
                $productVariant = ProductVariant::updateOrCreate([
                    'product_id' => $product->id,
                    'sku_code' => $skuCode,
                    'name' => $variant['name'],
                    'value' => $variant['value'],
                ], [
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'value' => $variant['value'],
                    'sku_code' => $skuCode,
                    'original_price' => $variant['original_price'],
                    'selling_price' => $variant['selling_price'],
                    'discounted_price' => $variant['discounted_price'],
                    'discount_percentage' => $variant['discount_percentage'],
                    'quantity' => $variant['quantity'],
                    'featured' => $variant['featured'],
                    'active' => $variant['active'],
                    'thumbnail' => $variant['thumbnail'],
                    'order' => $variant['order'],
                ]);

                // Link Variant Attributes ...
                $productVariant->productVariantValues()->sync($attrValueIds);
            }
        }

        // Upload Images in ProductObserver ...
//        if (request()->has('images')) {
//            foreach (request()->images as $image) {
//                try {
//                    $product->addMedia('storage/' . $image)
//                        ->preservingOriginal()
//                        ->toMediaCollection('products');
//                    deleteFile($image);
//                } catch (FileDoesNotExist|FileIsTooBig $e) {
//                    Log::info($e);
//                }
//            }
//        }

        return $product;
    }

//  public function store($request)
//  {
//    $data = $request->validated();
//    unset($data['image'], $data['logo'], $data['name']);
//    $data['name'] = strtolower($request->name);
//
//    $name = str_replace(' ', '_', $data['name']);
//
//    // Brand Logo Upload
//    if ($request->has('logoLinks')) {
//      $data['logo'] = json_decode($request->logoLinks) ? json_decode($request->logoLinks)[0] : '';
//    } else if ($request->hasFile('logo')) {
//      $data['logo'] = uploadFile($request->logo, 'images/brand', $name);
//    }
//
//    // Brand Image Upload
//    if ($request->has('imageLinks')) {
//      $data['image'] = json_decode($request->imageLinks) ? json_decode($request->imageLinks)[0] : '';
//    } else if ($request->hasFile('image')) {
//      $data['image'] = uploadFile($request->image, 'images/brand', $name);
//    }
//
//    return Brand::create($data);
//  }
//
//  public function update($request, $brand)
//  {
//    $data = $request->validated();
//    unset($data['image'], $data['logo'], $data['name']);
//    $data['name'] = strtolower($request->name);
//
//    $name = str_replace(' ', '_', $data['name']);
//
//    // Brand Logo Upload
//    if ($request->has('logoLinks')) {
//      $data['logo'] = json_decode($request->logoLinks) ? json_decode($request->logoLinks)[0] : '';
//    } else if ($request->hasFile('logo')) {
//      $data['logo'] = uploadFile($request->logo, 'images/brand', $name);
//    }
//
//    // Brand Image Upload
//    if ($request->has('imageLinks')) {
//      $data['image'] = json_decode($request->imageLinks) ? json_decode($request->imageLinks)[0] : '';
//    } else if ($request->hasFile('image')) {
//      $data['image'] = uploadFile($request->image, 'images/brand', $name);
//    }
//
//    // Delete old files
//    if ($data['logo'] && $brand->logo) deleteFile($brand->logo);
//    if ($data['image'] && $brand->image) deleteFile($brand->image);
//
//    return $brand->update($data);
//  }
}
