<?php

namespace App\Http\Services\PageManager;

use App\Models\Section;
use Illuminate\Support\Facades\Cache;

class SectionService
{
    public function getAll()
    {
        return Cache::rememberForever('sections', function () {
            return Section::trash()
                ->latest()->get();
        });
    }

    public function store($request): Section
    {
        $data = $request->validated();
        $section = new Section();
        $section->fill($data);
        $section->save();

        return $section;
    }

    public function update($request, Section $section): Section
    {
        $data = $request->validated();
        $section->fill($data);
        $section->save();

        return $section;
    }
}
