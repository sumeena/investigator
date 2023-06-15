<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            StateSeeder::class,
            LanguageSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            TimezoneSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
