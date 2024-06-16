<?php

use App\Http\Controllers\Api\Admin\CoreSettingController;
use App\Http\Controllers\Api\Admin\SettingsController;
use App\Http\Controllers\Api\ImageUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Image Upload ...
Route::post('upload-file', [ImageUploadController::class, 'store']);
Route::post('remove-uploaded-file', [ImageUploadController::class, 'delete']);
Route::delete('remove-media/{media}', [ImageUploadController::class, 'deleteMedia']);

// Settings ...
Route::get('all-settings', function () {
    return response()->json([
        'data' => [
            'system_settings' => appSettings(),
            'core_settings' => appCoreSettings(),
            'social_auth_settings' => socialAuthSettings(),
        ]
    ]);
});
Route::get('settings', [SettingsController::class, 'index']);
Route::get('core-settings', [CoreSettingController::class, 'index']);

require __DIR__ . '/api/admin/v1.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/api/web/v1.php';



//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');
