<?php

namespace App\Traits;

trait PhotoUploader
{
    public function uploadPhoto($photo, $path = '', $name = ''): string
    {
        $file_name = $name . '_' . time() . '.' . $photo->getClientOriginalExtension();
        $path = '/uploads/images/' . $path;
        $photo->move(public_path($path), $file_name);
        return $path . '/' . $file_name;
    }

    public function deletePhoto($photo): void
    {
        if (file_exists(public_path($photo))) {
            unlink(public_path($photo));
        }
    }

    public function uploadPhotos($photos, $path = 'photo'): array
    {
        $file_names = [];
        foreach ($photos as $photo) {
            $file_name = time() . '.' . $photo->getClientOriginalExtension();
            $path = '/uploads/images/' . $path;
            $photo->move(public_path($path), $file_name);
            $file_names[] = $path . '/' . $file_name;
        }
        return $file_names;
    }

    public function deletePhotos($photos): void
    {
        foreach ($photos as $photo) {
            if (file_exists(public_path($photo))) {
                unlink(public_path($photo));
            }
        }
    }
}
