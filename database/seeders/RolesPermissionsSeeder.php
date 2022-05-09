<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{




    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {

            DB::beginTransaction();
            foreach (config('permission.roles_permissions') as $role => $permissions) {

                $new_role = Role::create(['name' => $role, 'guard_name' => 'admin', 'created_at' => now()]);
                $role_permissions = collect($permissions)->map(
                    fn ($permission) => ['name' => $permission, 'guard_name' => 'admin', 'created_at' => now()]
                )->toArray();

                Permission::insert($role_permissions);

                $new_role->syncPermissions($permissions);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->command->error($th->getMessage() . 'error');

            return false;
        }
    }
}
