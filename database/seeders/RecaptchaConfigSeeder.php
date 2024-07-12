<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecaptchaConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('business_configurations')->insert([
            'key' => 'google_recaptcha',
            'group' => 'third_party',
            'live_values' => json_encode([
                'site_key' => env('RECAPTCHA_SITE_KEY'),
                'secret_key' => env('RECAPTCHA_SECRET_KEY'),
                'third_party_key' => 'google_recaptcha',
            ]),
            'test_values' => json_encode([
                'site_key' => env('RECAPTCHA_SITE_KEY'),
                'secret_key' => env('RECAPTCHA_SECRET_KEY'),
                'third_party_key' => 'google_recaptcha',
            ]),
            'is_active' => true,
        ]);
    }
}
