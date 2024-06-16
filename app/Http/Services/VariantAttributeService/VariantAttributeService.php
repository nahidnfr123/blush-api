<?php

namespace App\Http\Services\VariantAttributeService;

use App\Models\VariantAttribute;

class VariantAttributeService
{
    public function getAll()
    {
        return VariantAttribute::trash()
            ->search(request('query'), ['%name', '%slug'])
            ->orderBy(request('order_by', 'created_at'), request('order', 'ASC'))
            ->paginate(perPage());
    }

    public function store($request): VariantAttribute
    {
        $data = $request->validated();

        return VariantAttribute::create($data);
    }

    public function update($request, VariantAttribute $variant): VariantAttribute
    {
        $data = $request->validated();
        $variant->update($data);

        return $variant;
    }
}
