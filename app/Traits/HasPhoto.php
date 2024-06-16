<?php

namespace App\Traits;

use App\Actions\UploadManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasPhoto
{
    public static function bootHasPhoto()
    {

    }

    public static function initializeHasPhoto()
    {
        static::saving(function ($model) {
            if (request()->hasFile('photo')) {
                $path = strtolower(Str::plural(class_basename($model)));
                $model->photo = (new UploadManager())->inputFile(request()->file('photo'))->uploadFile($path);
            } elseif (request()->has('photo') && !!request('photo')) {
                $directory = strtolower(Str::plural(class_basename($model)));
                $path = (new UploadManager())->moveFile(request('photo'), $directory);
                $model->photo = $path;
            }
//            else {
//                $oldModel = $model->where('id', $model->id)->first();
//                $path = null;
//                if ($oldModel) {
//                    $path = $oldModel->getAttributes()['photo'];
//                }
//                $model->photo = $path;
//            }
        });
    }

    public function getPhotoAttribute($photo): ?string
    {
        return $photo ? Storage::url($photo) : null;
    }
}
