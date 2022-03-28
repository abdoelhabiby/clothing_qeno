<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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

		//disable foreign key check for this connection before running seeders
		\DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        $this->call(AdminSeeder::class);
        $this->call(CategorySeeder::class);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
