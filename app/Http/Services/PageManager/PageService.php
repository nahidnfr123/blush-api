<?php

namespace App\Http\Services\PageManager;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Support\Facades\Cache;

class PageService
{
    public function getAll()
    {
//        return Cache::rememberForever('pages', function () {
        return Page::with('sections')
            ->trash()
            ->search(request('query'), ['%name', '%slug'])
            ->latest()
            ->paginate(perPage());
//        });
    }

    public function store($request): Page
    {
        $data = $request->validated();
        $page = new Page();
        $page->fill($data);
        $page->save();

        $section = new Section();
        $dataSections = $request->sections;
        $dataSections['page_id'] = $page->id;
        $section->fill($dataSections);
        $section->save();

        return $page;
    }

    public function update($request, Page $page): Page
    {
        $data = $request->validated();
        $page->fill($data);
        $page->save();

        return $page;
    }
}
