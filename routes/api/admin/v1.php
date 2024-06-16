<?php

use App\Enums\GuardEnums;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\CommonAdminController;
use App\Http\Controllers\Api\Admin\CoreSettingController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\GridController;
use App\Http\Controllers\Api\Admin\SlideController;
use App\Http\Controllers\Api\Admin\PageController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\SectionController;
use App\Http\Controllers\Api\Admin\SettingsController;
use App\Http\Controllers\Api\Admin\SocialAuthSettingController;
use App\Http\Controllers\Api\Admin\TagController;
use App\Http\Controllers\Api\Admin\VariantAttributeController;
use App\Http\Controllers\Api\Admin\VariantAttributeValueController;
use App\Http\Controllers\Api\ArrangeOrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['cors', 'json',]], function () {
    Route::post('login', [AdminAuthController::class, 'login'])
        ->middleware('guest', 'throttle:6,1');
    // Route::post('register', [AdminAuthController::class, 'register']);

//    Route::group(['middleware' => ['cors', 'json', 'auth:admin-api', 'is_admin', 'role:super admin|admin']], function () {
    Route::group(['middleware' => ['auth:' . GuardEnums::Admin->value, 'is_admin']], function () {
        Route::post('logout', [AdminAuthController::class, 'logout']);
        Route::get('user', [AdminAuthController::class, 'user']);


        Route::middleware('verified')->group(function () {
            Route::get('sidebar-items', [DashboardController::class, 'sidebarItems']);

            // Admin user routes ...
            Route::apiResource('users', AdminUserController::class);
            Route::put('user/update-profile/{admin}', [AdminUserController::class, 'updateProfile']);
            Route::post('user/update-password', [AdminUserController::class, 'updatePassword']);
            Route::put('user/toggle-trash-mode', [AdminUserController::class, 'toggleTrashMode']);
            Route::group(['prefix' => 'users/-/', 'as' => 'tag.'], function () {
                Route::delete('bulk-delete', [AdminUserController::class, 'bulkDestroy']);
                Route::put('restore/{user}', [AdminUserController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{user}', [AdminUserController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [AdminUserController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [AdminUserController::class, 'bulkForceDelete']);
            });

            // Clear Cache ...
            Route::get('cache-clear', [DashboardController::class, 'clearCache']);

            // roles ...
            Route::apiResource('roles', RoleController::class);
            Route::group(['prefix' => 'roles/-/', 'as' => 'tag.'], function () {
                Route::delete('bulk-delete', [RoleController::class, 'bulkDestroy']);
                Route::put('restore/{role}', [RoleController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{role}', [RoleController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [RoleController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [RoleController::class, 'bulkForceDelete']);
            });
            // permissions ...
            Route::get('/permissions', [PermissionController::class, 'index']);
            Route::post('/assign-permission-to-role', [PermissionController::class, 'assignPermissionToRole']);

            // Settings ...
            Route::apiResource('/settings', SettingsController::class)->only(['index', 'store']);

            // Core Settings ...
            Route::apiResource('/core-settings', CoreSettingController::class)->only(['index', 'store']);

            // Social Auth Settings ...
            Route::apiResource('social-auth-settings', SocialAuthSettingController::class)->except(['show']);

            // Brand ...
            Route::apiResource('brand', BrandController::class);
            Route::group(['prefix' => 'brand/-/', 'as' => 'brand.'], function () {
                Route::delete('bulk-delete', [BrandController::class, 'bulkDestroy']);
                Route::put('restore/{brand}', [BrandController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{brand}', [BrandController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [BrandController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [BrandController::class, 'bulkForceDelete']);
            });

            // Tags ...
            Route::apiResource('tag', TagController::class);
            Route::group(['prefix' => 'tag/-/', 'as' => 'tag.'], function () {
                Route::delete('bulk-delete', [TagController::class, 'bulkDestroy']);
                Route::put('restore/{tag}', [TagController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{tag}', [TagController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [TagController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [TagController::class, 'bulkForceDelete']);
            });

            // Categories ...
            Route::apiResource('category', CategoryController::class);
            Route::group(['prefix' => 'category/-/', 'as' => 'category.'], function () {
                Route::delete('bulk-delete', [CategoryController::class, 'bulkDestroy']);
                Route::put('restore/{category}', [CategoryController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{category}', [CategoryController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [CategoryController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [CategoryController::class, 'bulkForceDelete']);
            });

            // Products ...
            Route::apiResource('products', ProductController::class);
            Route::group(['prefix' => 'products/-/', 'as' => 'products.'], function () {
                Route::delete('bulk-delete', [ProductController::class, 'bulkDestroy']);
                Route::put('restore/{product}', [ProductController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{product}', [ProductController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [ProductController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [ProductController::class, 'bulkForceDelete']);
            });

            // Variant Attributes ...
            Route::apiResource('variant-attributes', VariantAttributeController::class);
            Route::group(['prefix' => 'variant-attributes/-/', 'as' => 'variantAttribute.'], function () {
                Route::delete('bulk-delete', [VariantAttributeController::class, 'bulkDestroy']);
                Route::put('restore/{variant_attribute}', [VariantAttributeController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{variant_attribute}', [VariantAttributeController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [VariantAttributeController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [VariantAttributeController::class, 'bulkForceDelete']);
            });

            // Variant Attribute Values ...
            Route::apiResource('variant-attribute-values', VariantAttributeValueController::class);
            Route::group(['prefix' => 'variant-attribute-values/-/', 'as' => 'variantAttributeValue.'], function () {
                Route::delete('bulk-delete', [VariantAttributeValueController::class, 'bulkDestroy']);
                Route::put('restore/{variant_attribute_value}', [VariantAttributeValueController::class, 'restore'])->withTrashed();
                Route::delete('force-delete/{variant_attribute_value}', [VariantAttributeValueController::class, 'forceDelete'])->withTrashed();
                Route::put('bulk-restore', [VariantAttributeValueController::class, 'bulkRestore']);
                Route::delete('bulk-force-delete', [VariantAttributeValueController::class, 'bulkForceDelete']);
            });


            // Page Manager ...
            Route::group(['prefix' => 'page-manager', 'as' => 'page-manager.'], function () {
                // Home Grid ...
                Route::apiResource('grids', GridController::class);
                Route::group(['prefix' => 'grids/-/', 'as' => 'grid.'], function () {
                    Route::delete('bulk-delete', [GridController::class, 'bulkDestroy']);
                    Route::put('restore/{grid}', [GridController::class, 'restore'])->withTrashed();
                    Route::delete('force-delete/{grid}', [GridController::class, 'forceDelete'])->withTrashed();
                    Route::put('bulk-restore', [GridController::class, 'bulkRestore']);
                    Route::delete('bulk-force-delete', [GridController::class, 'bulkForceDelete']);
                });

                // Home Page Slides ...
                Route::apiResource('slides', SlideController::class);
                Route::group(['prefix' => 'slides/-/', 'as' => 'slide.'], function () {
                    Route::delete('bulk-delete', [SlideController::class, 'bulkDestroy']);
                    Route::put('restore/{slide}', [SlideController::class, 'restore'])->withTrashed();
                    Route::delete('force-delete/{slide}', [SlideController::class, 'forceDelete'])->withTrashed();
                    Route::put('bulk-restore', [SlideController::class, 'bulkRestore']);
                    Route::delete('bulk-force-delete', [SlideController::class, 'bulkForceDelete']);
                });

                // Page ...
                Route::apiResource('pages', PageController::class);
                Route::group(['prefix' => 'pages/-/', 'as' => 'page.'], function () {
                    Route::delete('bulk-delete', [PageController::class, 'bulkDestroy']);
                    Route::put('restore/{page}', [PageController::class, 'restore'])->withTrashed();
                    Route::delete('force-delete/{page}', [PageController::class, 'forceDelete'])->withTrashed();
                    Route::put('bulk-restore', [PageController::class, 'bulkRestore']);
                    Route::delete('bulk-force-delete', [PageController::class, 'bulkForceDelete']);
                });

                // Section ...
                Route::apiResource('section', SectionController::class);
                Route::group(['prefix' => 'section/-/', 'as' => 'section.'], function () {
                    Route::delete('bulk-delete', [SectionController::class, 'bulkDestroy']);
                    Route::put('restore/{section}', [SectionController::class, 'restore'])->withTrashed();
                    Route::delete('force-delete/{section}', [SectionController::class, 'forceDelete'])->withTrashed();
                    Route::put('bulk-restore', [SectionController::class, 'bulkRestore']);
                    Route::delete('bulk-force-delete', [SectionController::class, 'bulkForceDelete']);
                });
            });

            // Arrange Order ... APIs ...
            Route::post('arrange-item-order/{model_name}', [ArrangeOrderController::class, 'updateOrder']);
        });
    });
});


Route::get('product-form-data', [CommonAdminController::class, 'productFormData']);
Route::get('simple-categories', [CommonAdminController::class, 'categories']);
