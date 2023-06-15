<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'email'      => 'admin@gmail.com',
                'password'   => Hash::make('12345678'),
                'role'       => Role::where('role', 'admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'first_name' => 'Company',
                'last_name'  => 'Admin',
                'email'      => 'company_admin@gmail.com',
                'password'   => Hash::make('12345678'),
                'role'       => Role::where('role', 'company-admin')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'first_name' => 'Investigator',
                'last_name'  => 'Investigator',
                'email'      => 'investigator@gmail.com',
                'password'   => Hash::make('12345678'),
                'role'       => Role::where('role', 'investigator')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'first_name' => 'Hiring',
                'last_name'  => 'Manager',
                'email'      => 'hm@gmail.com',
                'password'   => Hash::make('12345678'),
                'role'       => Role::where('role', 'hiring-manager')->first()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        if (User::count()) {
            $this->command->info('Users table is not empty, skipping...');
            return;
        }

        User::insert($users);

        $this->command->info('Users seeded!');
    }
}
