<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'name' => 'English'
            ],
            [
                'name' => 'Spanish'
            ],
            [
                'name' => 'Chinese'
            ],
            [
                'name' => 'Tagalog'
            ],
            [
                'name' => 'Vietnamese'
            ],
            [
                'name' => 'Russian'
            ],
            [
                'name' => 'Ukrainian'
            ]
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Language::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Language::insert($languages);

        $this->command->info('Languages seeded!');
    }
}
