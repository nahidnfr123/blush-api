<?php

namespace App\Enums;

enum PageContentTypeEnums: string
{
    case Content = 'content';
    case Grid = 'grid';
    case ProductSlider = 'product_slider';
    case ImageSlider = 'image_slider';
    case VideoSlider = 'video_slider';
    case ProductList = 'product_list'; // list of products
    case SimpleList = 'simple_list'; // category list || brand list

    public static function values(): array
    {
        // return array_column(self::cases(), 'name', 'value');
        return array_map(fn($status) => $status, self::cases());
    }
}
