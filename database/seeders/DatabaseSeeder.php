<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \Eloquent::unguard();

	//	disable foreign key check for this connection before running seeders
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Role::truncate();
        Permission::truncate();

        // $this->call(AdminSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(ProductSeeder::class);

        $this->call(RolesPermissionsSeeder::class);
        $this->call(AdminsRolesPermissionsSeeder::class);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
