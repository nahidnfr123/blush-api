<?php

namespace App\Utils;

class Permissions
{
    public function permissionGroups(): array
    {
        return [
            'dashboard' => ['view dashboard'],
            'system setting' => [
                'view system setting',
                'update system setting'
            ],
            'core setting' => [
                ...$this->defaultPermissionsBasic('core setting'),
            ],
            'social auth setting' => [
                ...$this->defaultPermissionsBasic('social auth setting'),
            ],
            'log' => [
                'view log'
            ],
            'profile' => [
                'view profile',
                'update profile'
            ],
            'customer' => [
                ...$this->defaultPermissionsBasic('customer'),
                ...$this->trashedPermissions('customer')
            ],
            'admin' => [
                ...$this->defaultPermissionsExtended('admin'),
                ...$this->trashedPermissions('admin')
            ],
            'admin setting' => [
                'view admin setting',
                'update admin setting'
            ],
            'role' => [
                ...$this->defaultPermissionsBasic('role'),
                ...$this->trashedPermissions('role'),
                'view user role',
                'assign role to user',
            ],
            'permission' => [
                ...$this->defaultPermissionsBasic('permission'),
                "assign permission to role",
            ],
            'tag' => [
                ...$this->defaultPermissionsExtended('tag'),
                ...$this->trashedPermissions('tag')
            ],
            'brand' => [
                ...$this->defaultPermissionsExtended('brand'),
                ...$this->trashedPermissions('brand')
            ],
            'category' => [
                ...$this->defaultPermissionsExtended('category'),
                ...$this->trashedPermissions('category')
            ],
            'product' => [
                ...$this->defaultPermissionsExtended('product'),
                ...$this->trashedPermissions('product')
            ],
            'variant attribute' => [
                ...$this->defaultPermissionsExtended('variant attribute'),
                ...$this->trashedPermissions('variant attribute')
            ],
            'variant attribute value' => [
                ...$this->defaultPermissionsExtended('variant attribute value'),
                ...$this->trashedPermissions('variant attribute value')
            ],
            'coupon' => [
                ...$this->defaultPermissionsExtended('coupon'),
                ...$this->trashedPermissions('coupon')
            ],
            'order' => [
                ...$this->defaultPermissionsExtended('order'),
                ...$this->trashedPermissions('order')
            ],
            'page' => [
                ...$this->defaultPermissionsExtended('page'),
                ...$this->trashedPermissions('page')
            ],
            'grid' => [
                ...$this->defaultPermissionsExtended('grid'),
                ...$this->trashedPermissions('grid')
            ],
            'slide' => [
                ...$this->defaultPermissionsExtended('slide'),
                ...$this->trashedPermissions('slide')
            ],
        ];
    }

    function defaultPermissionsBasic($key): array
    {
        return [
            'view ' . $key,
            'show ' . $key,
            'create ' . $key,
            'update ' . $key,
            'delete ' . $key,
        ];
    }

    function defaultPermissionsExtended($key): array
    {
        return [
            'view ' . $key,
            'show ' . $key,
            'create ' . $key,
            'update ' . $key,
            'delete ' . $key,

            'view any ' . $key,
            'show any ' . $key,
            'update any ' . $key,
            'delete any ' . $key,
        ];
    }

    function trashedPermissions($key): array
    {
        return [
            'view trashed ' . $key,
            'restore ' . $key,
            'force delete ' . $key,
        ];
    }
}
