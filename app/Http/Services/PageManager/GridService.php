<?php

namespace App\Http\Services\PageManager;

use App\Models\Grid;
use App\Models\GridItem;

class GridService
{
    public function getAll()
    {
        return Grid::trash()
            ->search(request('query'), ['%title', '%slug'])
            ->search(request('active'), ['active'])
            ->orderBy('created_at', 'desc')
            ->orderBy('active', 'desc')
            ->paginate(perPage());
    }

    public function store($request): Grid
    {
        $data = $request->validated();
        $grid = new Grid();
        $grid->fill($data);
        $grid->save();

        $items = $data['items'];
        foreach ($items as $item) {
            $gridItem = new GridItem();
            unset($item['id']);
            if (isset($item['image'])) {
                if ($item['image'] && file_exists(storage_path('app/public/' . $item['image']))) {
                    if ($gridItem->image) deleteFile($gridItem->image);
                } else {
                    unset($item['image']);
                }
            }
            $item['grid_id'] = $grid->id;
            if (!$item['height']) {
                unset($item['height']);
            }
            $gridItem->fill($item);
            $gridItem->save();
        }

        return $grid->load('gridItems');
    }

    public function update($request, Grid $grid): Grid
    {
        $data = $request->validated();
        $grid->fill($data);
        $grid->save();

        $items = $data['items'];
        foreach ($items as $item) {
            $gridItem = GridItem::find($item['id']) ?? new GridItem();
            unset($item['id']);
            if (isset($item['image'])) {
                if ($item['image'] && file_exists(storage_path('app/public/' . $item['image']))) {
                    if ($gridItem->image) deleteFile($gridItem->image);
                } else {
                    unset($item['image']);
                }
            }
            $item['grid_id'] = $grid->id;
            if (!$item['height']) {
                unset($item['height']);
            }
            $gridItem->fill($item);
            $gridItem->save();
        }

        return $grid->load('gridItems');
    }
}
