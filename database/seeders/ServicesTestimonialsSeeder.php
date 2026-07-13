<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class ServicesTestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        if (Service::query()->count() === 0) {
            $services = [
                [
                    'title' => 'Web Development',
                    'description' => 'Custom Laravel and React applications, plus company websites built to handle day-to-day business needs.',
                    'icon' => 'code',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'CMS Websites',
                    'description' => 'WordPress Elementor and Wix Studio sites that look polished and stay easy for clients to update.',
                    'icon' => 'layout',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Database & APIs',
                    'description' => 'MySQL structure and API work that keeps your app data organized and connected to the rest of your stack.',
                    'icon' => 'database',
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Updates & Support',
                    'description' => 'Fixes, small features, and ongoing maintenance for sites already live — without starting from scratch.',
                    'icon' => 'wrench',
                    'sort_order' => 4,
                ],
            ];

            foreach ($services as $service) {
                Service::query()->create($service);
            }
        }

        if (Testimonial::query()->count() === 0) {
            $testimonials = [
                [
                    'name' => 'Sarah Chen',
                    'role' => 'Founder, Bloom Studio',
                    'quote' => 'Michaela delivered our e-commerce platform ahead of schedule. The code quality is excellent and the design exceeded our expectations.',
                    'avatar_initials' => 'SC',
                    'rating' => 5,
                    'sort_order' => 1,
                ],
                [
                    'name' => 'James Rivera',
                    'role' => 'Product Manager, NexaTech',
                    'quote' => 'Great communication throughout the project. He understood our requirements quickly and built a dashboard that our team uses every day.',
                    'avatar_initials' => 'JR',
                    'rating' => 5,
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Anna Lopez',
                    'role' => 'Marketing Director',
                    'quote' => 'Our portfolio site looks stunning and loads incredibly fast. I\'ve received so many compliments from clients since the launch.',
                    'avatar_initials' => 'AL',
                    'rating' => 5,
                    'sort_order' => 3,
                ],
            ];

            foreach ($testimonials as $testimonial) {
                Testimonial::query()->create($testimonial);
            }
        }
    }
}
