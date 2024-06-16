<?php

namespace Database\Seeders;

use App\Enums\GuardEnums as Guard;
use App\Utils\Permissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class RolesAndPermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Cache::forget('roles');
        Cache::forget('permissions');
        Artisan::call('optimize:clear');

        Model::unguard();
        Role::updateOrCreate(['name' => 'developer'], ['name' => 'developer', 'guard_name' => Guard::Admin->value]);
        Role::updateOrCreate(['name' => 'super admin'], ['name' => 'super admin', 'guard_name' => Guard::Admin->value]);
        Role::updateOrCreate(['name' => 'admin'], ['name' => 'admin', 'guard_name' => Guard::Admin->value]);
        Role::updateOrCreate(['name' => 'staff'], ['name' => 'staff', 'guard_name' => Guard::Admin->value]);

        Role::updateOrCreate(['name' => 'customer'], ['name' => 'customer']);
        // $this->call("OthersTableSeeder");


//        $path = base_path() . "/Permissions.json";
//        $permissionGroups = json_decode(file_get_contents($path), true);

        $permissions = new Permissions();

        foreach ($permissions->permissionGroups() as $key => $permissionGroup) {
            foreach ($permissionGroup as $permission) {
                Permission::updateOrCreate(
                    [
                        'name' => gettype($permission) == 'string' ? $permission : $permission[0],
                        'guard_name' => Guard::Admin->value
                    ],
                    [
                        'name' => gettype($permission) == 'string' ? $permission : $permission[0],
                        'type' => $key,
                        'guard_name' => Guard::Admin->value,
                        'special' => gettype($permission) == 'array' ? $permission[1] : 0
                    ]
                );
            }
        }

        Role::where('name', 'developer')->first()->syncPermissions(Permission::all());
        Role::where('name', 'super admin')->first()->syncPermissions(Permission::all());
    }
}
