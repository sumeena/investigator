<?php

namespace Database\Seeders;

use App\Models\Timezone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezones = [
            [
                'timezone'   => 'Pacific/Midway',
                'name'       => '(GMT -11:00) Midway Island, Samoa',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/Adak',
                'name'       => '(GMT -10:00) Hawai',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/Anchorage',
                'name'       => '(GMT -9:00) Alaska',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/Los_Angeles',
                'name'       => '(GMT -8:00) Pacific Time (US & Canada)',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/Denver',
                'name'       => '(GMT -7:00) Mountain Time (US & Canada)',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/Chicago',
                'name'       => '(GMT -6:00) Central Time (US & Canada), Mexico City',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/New_York',
                'name'       => '(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/Halifax',
                'name'       => '(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/St_Johns',
                'name'       => '(GMT -3:30) Newfoundland',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'America/Argentina/Buenos_Aires',
                'name'       => '(GMT -3:00) Brazil, Buenos Aires, Georgetown',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Atlantic/South_Georgia',
                'name'       => '(GMT -2:00) Mid-Atlantic',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Atlantic/Azores',
                'name'       => '(GMT -1:00 hour) Azores, Cape Verde Islands',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Europe/Dublin',
                'name'       => '(GMT) Western Europe Time, London, Lisbon, Casablanca',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Europe/Belgrade',
                'name'       => '(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Europe/Minsk',
                'name'       => '(GMT +2:00) Kaliningrad, South Africa',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Kuwait',
                'name'       => '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Tehran',
                'name'       => '(GMT +3:30) Tehran',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Muscat',
                'name'       => '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Kabul',
                'name'       => '(GMT +4:30) Kabu',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Karachi',
                'name'       => '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Kolkata',
                'name'       => '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Kathmandu',
                'name'       => '(GMT +5:45) Kathmandu',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Dhaka',
                'name'       => '(GMT +6:00) Almaty, Dhaka, Colombo',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Bangkok',
                'name'       => '(GMT +7:00) Bangkok, Hanoi, Jakarta',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Brunei',
                'name'       => '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Asia/Seoul',
                'name'       => '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Australia/Darwin',
                'name'       => '(GMT +9:30) Adelaide, Darwin',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Australia/Brisbane',
                'name'       => '(GMT +10:00) Eastern Australia, Guam, Vladivostok',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Australia/Canberra',
                'name'       => '(GMT +11:00) Magadan, Solomon Islands, New Caledonia',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'timezone'   => 'Pacific/Fiji',
                'name'       => '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka',
                'active'     => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Timezone::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Timezone::insert($timezones);

        $this->command->info('Timezones table seeded!');
    }
}
