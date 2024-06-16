<?php

namespace App\Http\Services;

use App\Models\Tag;

class TagService
{

    public function getAll()
    {
        // request() order_by, order, per_page, query trash
        return Tag::withCount('products')
            ->trash()
            ->search(request('query'), ['%name', '%slug'])
            ->orderBy(request('order_by', 'created_at'), request('order', 'ASC'))
            ->paginate(perPage());
    }

    public function store($request)
    {
        $data = $request->validated();
        $data['name'] = strtolower($data['name']);
        return Tag::create($data);
    }

    public function update($request, $tag)
    {
        $data = $request->validated();
        $data['name'] = strtolower($data['name']);
        $tag->update($data);
        return $tag;
    }
}
