<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Admin::truncate();

        Admin::firstOrCreate(['name' => 'tengen','email' => 't@t.com','password' => bcrypt(12345678)]);
    }
}
