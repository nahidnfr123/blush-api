<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SocialAuthSettingsRequest;
use App\Models\SocialAuthSetting;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class SocialAuthSettingController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $data = SocialAuthSetting::query();
        $query = \request('query');
        if ($query) {
            $searchFields = ['%slug', '%provider', 'client_id', 'client_secret', '%redirect_url'];
            $data->search($query, $searchFields);
        }
        $data = $data->latest()->get();
        return $this->success('Success', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAuthSettingsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        unset($data['logo']);
        if ($request->hasFile('logo')) {
            $data['logo'] = uploadFile($request->logo, 'images/social_auth', $data['provider'] . '_logo');
        }
        SocialAuthSetting::create($data);
        Cache::forget('socialAuth');
        return $this->success('Success', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialAuthSetting $socialAuthSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAuthSettingsRequest $request, SocialAuthSetting $socialAuthSetting): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $data['active'] = $request->has('active');
        unset($data['logo']);
        if ($request->hasFile('logo')) {
            $data['logo'] = uploadFile($request->logo, 'images/social_auth', $data['provider'] . '_logo');
            if ($data['logo'] && $socialAuthSetting->logo) deleteFile($socialAuthSetting->logo);
        }
        $socialAuthSetting->update($data);
        $socialAuthSetting->touch();
        Cache::forget('socialAuth');
        return $this->success('Success', $socialAuthSetting);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialAuthSetting $socialAuthSetting): \Illuminate\Http\JsonResponse
    {
        $socialAuthSetting->delete();
        Cache::forget('socialAuth');
        return $this->success('Success');
    }
}
