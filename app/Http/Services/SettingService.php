<?php

namespace App\Http\Services;

use App\Models\Setting;

class SettingService
{
    public function store($request)
    {
        $setting = Setting::first();
        $data = $request->validated();
        unset($data['site_logo'], $data['site_favicon']);
        $name = str_replace(' ', '_', $data['site_name']);

        if ($request->hasFile('site_logo')) {
            $data['site_logo'] = uploadFile($request->site_logo, 'images/site/logo', $name . '_logo');
            if ($data['site_logo'] && $setting && $setting->site_logo) {
                deleteFile($setting->getRawOriginal('site_logo'));
            }
        }
        if ($request->hasFile('site_favicon')) {
            $data['site_favicon'] = uploadFile($request->site_favicon, 'images/site/logo', $name . '_favicon');
            if ($data['site_favicon'] && $setting && $setting->site_favicon) {
                deleteFile($setting->getRawOriginal('site_favicon'));
            }
        }

        if ($request->site_logo_link && file_exists(storage_path('app/public/' . $request->site_logo_link))) {
            $data['site_logo'] = $request->site_logo_link;
        }
        if ($request->site_favicon_link && file_exists(storage_path('app/public/' . $request->site_favicon_link))) {
            $data['site_favicon'] = $request->site_favicon_link;
        }

        $setting = Setting::updateOrCreate(['id' => 1], $data);
        $setting->refresh();
        return $setting;
    }
}
