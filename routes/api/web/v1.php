<?php


use App\Http\Controllers\Api\Admin\SettingsController;
use App\Http\Controllers\Api\Web\MainController;
use App\Http\Controllers\Api\Web\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', [UserController::class, 'me']);
});


Route::get('categories', [MainController::class, 'categories']);

Route::get('products', [MainController::class, 'products']);

// Queryable Routes ...
Route::get('get-grid', [MainController::class, 'getGrid']);
Route::get('get-categories', [MainController::class, 'getCategories']);
Route::get('get-brands', [MainController::class, 'getBrands']);
Route::get('get-products', [MainController::class, 'getProducts']);




