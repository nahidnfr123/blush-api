<?php

namespace App\Utils;

use App\Enums\GuardEnums;

class AdminSidebar
{
    public function sideBarItems(): array
    {
        $user = auth(GuardEnums::Admin->value)->user();
        $menuItems = [
            ['header' => 'Dashboards'],
            [
                'title' => 'Ecommerce',
                'icon' => 'mdi-cart-outline',
                'to' => '/',
                'permission' => 'view dashboard',
            ],
            ['header' => 'Shop'],
            [
                'group' => '/shop/',
                'model' => false,
                'icon' => 'mdi-grid',
                'title' => 'Manage Products',
                'children' => [
                    [
                        'title' => 'Products',
//                        'icon' => 'mdi-checkbox-marked',
                        'icon' => 'mdi-lingerie',
                        'to' => '/shop/products',
                        'permission' => ['view product', 'view any product'],
                    ],
                    [
                        'title' => 'Categories',
                        'icon' => 'mdi-graph',
                        'to' => '/shop/categories',
                        'permission' => ['view category', 'view any category'],
                    ],
                    [
                        'title' => 'Brands',
                        'icon' => 'mdi-star',
                        'to' => '/shop/brands',
                        'permission' => ['view brand', 'view any brand'],
                    ],
                    [
                        'title' => 'Tags',
                        'icon' => 'mdi-tag',
                        'to' => '/shop/tags',
                        'permission' => ['view tag', 'view any tag'],
                    ],
                    [
                        'title' => 'Attributes',
                        'icon' => 'mdi-package-variant',
                        'to' => '/shop/attributes',
                        'permission' => ['view variant attribute', 'view any variant attribute'],
                    ],
                    [
                        'title' => 'Coupons',
                        'icon' => 'mdi-ticket-percent',
                        'to' => '/shop/coupons',
                        'permission' => ['view coupon', 'view any coupon'],
                    ],
                ],
            ],
            ['header' => 'Access Control'],
            [
                'group' => '/access-control/',
                'model' => false,
                'icon' => 'mdi-lock',
                'title' => 'Access Control',
                'children' => [
                    [
                        'title' => 'Roles',
                        'icon' => 'mdi-account-key',
                        'to' => '/access-control/roles',
                        'permission' => 'view role'
                    ],
//                    [
//                        'title' => 'Permissions',
//                        'icon' => 'mdi-account-lock',
//                        'to' => '/access-control/permissions',
//                        'permission' => 'view permission'
//                    ],
                    [
                        'title' => 'System Users',
                        'icon' => 'mdi-account-multiple',
                        'to' => '/access-control/system-users',
                        'permission' => ['view admin', 'view any admin'],
                    ],
                ]
            ],
            [
                'title' => 'Customers',
                'icon' => 'mdi-account-multiple',
                'to' => '/user/customers',
                'permission' => 'view customer',
            ],
            ['header' => 'Pages'],
            [
                'title' => 'Grid',
                'icon' => 'mdi-grid',
                'to' => '/page-manager/grid',
                'permission' => 'view grid',
            ],
            [
                'title' => 'Slides',
                'icon' => 'mdi-slide',
                'to' => '/page-manager/slides',
                'permission' => 'view slide',
            ],
            [
                'title' => 'Page Manager',
                'icon' => 'mdi-page-layout-header',
                'to' => '/page-manager/',
                'permission' => 'view page',
            ],
            ['header' => 'Configuration'],
            [
                'title' => 'System Setting',
                'icon' => 'mdi-cog',
                'to' => '/configuration/system-settings',
                'permission' => 'view system setting',
            ],
            [
                'title' => 'Shop Settings',
                'icon' => 'mdi-cog-outline',
                'to' => '/configuration/core-settings',
                'permission' => 'view core setting',
            ],
            [
                'title' => 'Social Auth Settings',
                'icon' => 'mdi-cogs',
                'to' => '/configuration/social-auth-settings',
                'permission' => "view social auth setting'",
            ],
        ];


        // Recursive function to check permissions in children
        $checkPermissions = function ($items) use (&$checkPermissions, $user) {
            return collect($items)->map(function ($item) use ($checkPermissions, $user) {
                if (isset($item['children'])) {
                    $item['children'] = $checkPermissions($item['children']);
                }

                if (isset($item['permission'])) {
                    if ($user->can($item['permission'])) {
                        unset($item['permission']);
                        return $item;
                    }
                } else {
                    return $item;
                }
            })->filter()->values()->toArray();
        };

        // Call the recursive function on the top-level items
        return $checkPermissions($menuItems);
    }
}
