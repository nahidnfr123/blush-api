<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'files' => 'required_if:file,null|array|min:1|max:10|nullable',
                'files.*' => 'required_if:files,null|nullable|mimes:jpeg,png,jpg,gif,svg,jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:10240',
                'file' => 'required_if:files,null|nullable|mimes:jpeg,png,jpg,gif,svg,jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:10240',
                'path' => 'nullable|string',
                'name' => 'nullable|string'
            ]);

            $image_path = [];
            if ($request->hasFile('file')) {
                $image_path[] = uploadFile($request->file, $request->path ?? 'files', $request->name);
            } elseif ($request->hasFile('files')) {
                foreach ($request->file('files') as $f => $file) {
                    $file = $request->file('files')[$f];
                    $path = $request->path;
                    $image_path[] = uploadFile($file, $path, $request->name);
                }
            }
            return $this->success('You have successfully uploaded an image.', $image_path);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'path' => 'required|string'
            ]);

            $path = $request->path;

            // Remove the base URL from the path if it exists
            if (str_starts_with($path, config('app.url'))) {
                $url = config('app.url') . '/storage/';
                $path = str_replace($url, '', $path);
            }
            deleteFile($path);
            return $this->success('You have successfully removed an image.', $path);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
    }

    public function deleteMedia(Media $media): \Illuminate\Http\JsonResponse
    {
        try {
            $media->delete();
            return $this->success('You have successfully removed an image.', $media);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
    }
}
