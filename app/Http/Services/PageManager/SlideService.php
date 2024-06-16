<?php

namespace App\Http\Services\PageManager;

use App\Models\Slide;

class SlideService
{
    public function getAll()
    {
        return Slide::orderBy('order', 'ASC')->get();
    }

    public function store($request): Slide
    {
        $data = $request->validated();

        return Slide::create($data);
    }

    public function update($request, Slide $homeSlide): Slide
    {
        $data = $request->validated();
        $homeSlide->update($data);

        return $homeSlide;
    }
}
