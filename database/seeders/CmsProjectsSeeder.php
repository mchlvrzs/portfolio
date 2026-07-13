<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class CmsProjectsSeeder extends Seeder
{
    public function run(): void
    {
        // Tag existing rows as custom development
        Project::query()->whereNull('category')->orWhere('category', '')->update(['category' => 'development']);

        if (Project::query()->where('category', 'cms')->exists()) {
            return;
        }

        $cmsProjects = [
            [
                'title' => 'Spotlight.ai',
                'description' => 'Enterprise sales marketing site built in Wix Studio — dark high-tech layout, product storytelling, and demo CTAs for an AI knowledge-graph platform.',
                'tech_stack' => ['Wix Studio', 'Wix', 'Design'],
                'live_url' => 'https://www.spotlight.ai/',
                'github_url' => null,
                'image_gradient' => 'from-purple-50 to-purple-200',
                'image_path' => 'images/spotlight.png',
                'featured' => true,
                'category' => 'cms',
                'sort_order' => 4,
            ],
            [
                'title' => 'Run Away With Me',
                'description' => 'Napa & Sonoma wedding planning site in Wix Studio — romantic full-bleed hero, service packages, and consultation CTAs.',
                'tech_stack' => ['Wix Studio', 'Wix', 'Design'],
                'live_url' => 'https://www.runawaywithme.com/',
                'github_url' => null,
                'image_gradient' => 'from-purple-100 to-purple-300',
                'image_path' => 'images/runawaywithme.png',
                'featured' => true,
                'category' => 'cms',
                'sort_order' => 5,
            ],
            [
                'title' => 'i3 Power & Energy',
                'description' => 'Utility grid modernization marketing site in Wix Studio — dark technical hero, framework storytelling, and project CTAs.',
                'tech_stack' => ['Wix Studio', 'Wix', 'Design'],
                'live_url' => 'https://www.i3powerenergy.com/',
                'github_url' => null,
                'image_gradient' => 'from-purple-50 to-purple-200',
                'image_path' => 'images/i3powerenergy.png',
                'featured' => true,
                'category' => 'cms',
                'sort_order' => 6,
            ],
            [
                'title' => 'Cyth Systems',
                'description' => 'Test & measurement automation site in Wix Studio with Velo — product catalog, engineering services, and custom interactions.',
                'tech_stack' => ['Wix Studio', 'Velo', 'Wix'],
                'live_url' => 'https://www.cyth.com/',
                'github_url' => null,
                'image_gradient' => 'from-purple-100 to-purple-300',
                'image_path' => 'images/cyth.png',
                'featured' => true,
                'category' => 'cms',
                'sort_order' => 7,
            ],
            [
                'title' => 'Bricon Associates',
                'description' => 'Singapore insurance agency site on WordPress Elementor — product browsing for individuals and businesses with quote CTAs.',
                'tech_stack' => ['WordPress', 'Elementor'],
                'live_url' => 'https://bricon.com.sg/',
                'github_url' => null,
                'image_gradient' => 'from-purple-50 to-purple-200',
                'image_path' => 'images/bricon.png',
                'featured' => true,
                'category' => 'cms',
                'sort_order' => 8,
            ],
            [
                'title' => 'Juscall Insurance',
                'description' => 'Philippines health insurance agency site on WordPress Elementor — plans, claims assistance, and insurer partnerships.',
                'tech_stack' => ['WordPress', 'Elementor'],
                'live_url' => 'https://juscall.com.ph/',
                'github_url' => null,
                'image_gradient' => 'from-purple-100 to-purple-300',
                'image_path' => 'images/juscall.png',
                'featured' => true,
                'category' => 'cms',
                'sort_order' => 9,
            ],
            [
                'title' => 'RIG Associates',
                'description' => 'Singapore insurance brokerage site on WordPress Elementor — health, home, and business coverage with quote CTAs.',
                'tech_stack' => ['WordPress', 'Elementor'],
                'live_url' => 'https://www.rig-associates.com/',
                'github_url' => null,
                'image_gradient' => 'from-purple-50 to-purple-200',
                'image_path' => 'images/rig.png',
                'featured' => true,
                'category' => 'cms',
                'sort_order' => 10,
            ],
        ];

        foreach ($cmsProjects as $project) {
            Project::query()->create($project);
        }
    }
}
