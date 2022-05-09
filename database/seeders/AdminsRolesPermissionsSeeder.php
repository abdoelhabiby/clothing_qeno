<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminsRolesPermissionsSeeder extends Seeder
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

            $roles = Role::pluck('name');


            $admin = Admin::where('email', 't@t.com')->first();

            $admin->syncRoles($roles);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->command->error($th->getMessage() . 'error');

            return false;
        }
    }
}
