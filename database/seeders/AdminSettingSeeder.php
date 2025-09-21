<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminSetting;

class AdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin settings
        AdminSetting::updateOrCreate(
            ['key' => 'content_fallback_enabled'],
            [
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable fallback content from admin when class has no assigned content',
                'is_active' => true,
            ]
        );

        AdminSetting::updateOrCreate(
            ['key' => 'fallback_geography_models'],
            [
                'value' => '[]',
                'type' => 'json',
                'description' => 'Geography models to show as fallback content',
                'is_active' => true,
            ]
        );

        AdminSetting::updateOrCreate(
            ['key' => 'fallback_places'],
            [
                'value' => '[]',
                'type' => 'json',
                'description' => 'Places to show as fallback content',
                'is_active' => true,
            ]
        );

        AdminSetting::updateOrCreate(
            ['key' => 'fallback_stories'],
            [
                'value' => '[]',
                'type' => 'json',
                'description' => 'Stories to show as fallback content',
                'is_active' => true,
            ]
        );
    }
}
