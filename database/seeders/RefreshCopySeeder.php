<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Service;
use Illuminate\Database\Seeder;

/** Refresh profile bio + service copy without wiping projects. */
class RefreshCopySeeder extends Seeder
{
    public function run(): void
    {
        Profile::query()->update([
            'title' => 'Full Stack Developer',
            'bio' => 'I develop and maintain web applications with Laravel, React, and Node.js, and build business websites on WordPress, Wix Studio, and Shopify. Most of my work is for insurance, hospitality, and service companies that need a clear site and tools their team can actually use.',
        ]);

        $services = [
            1 => [
                'title' => 'Web Development',
                'description' => 'Custom Laravel and React applications, plus company websites built to handle day-to-day business needs.',
                'icon' => 'code',
            ],
            2 => [
                'title' => 'CMS Websites',
                'description' => 'WordPress Elementor and Wix Studio sites that look polished and stay easy for clients to update.',
                'icon' => 'layout',
            ],
            3 => [
                'title' => 'Database & APIs',
                'description' => 'MySQL structure and API work that keeps your app data organized and connected to the rest of your stack.',
                'icon' => 'database',
            ],
            4 => [
                'title' => 'Updates & Support',
                'description' => 'Fixes, small features, and ongoing maintenance for sites already live — without starting from scratch.',
                'icon' => 'wrench',
            ],
        ];

        foreach ($services as $order => $data) {
            Service::query()->updateOrCreate(
                ['sort_order' => $order],
                array_merge($data, ['sort_order' => $order])
            );
        }
    }
}
