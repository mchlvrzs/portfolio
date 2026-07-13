<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Profile::query()->create([
            'name' => 'Michaela',
            'title' => 'Full Stack Developer',
            'bio' => 'I develop and maintain web applications with Laravel, React, and Node.js, and build business websites on WordPress, Wix Studio, and Shopify. Most of my work is for insurance, hospitality, and service companies that need a clear site and tools their team can actually use.',
            'email' => 'michaelaverzosa26@gmail.com',
            'whatsapp' => '+63 995 791 9915',
            'location' => 'Philippines',
            'github_url' => null,
            'linkedin_url' => 'https://www.linkedin.com/in/michaela-verzosa-696185284',
            'facebook_url' => 'https://www.facebook.com/michaela.veeeeeeeeee/',
            'instagram_url' => 'https://www.instagram.com/mchlvrzs/',
            'twitter_url' => null,
            'resume_url' => null,
            'avatar_initials' => 'MV',
            'avatar_path' => 'images/hero.png',
        ]);

        $skills = [
            // Technical
            ['name' => 'HTML', 'category' => 'Technical Skills', 'proficiency' => 95, 'sort_order' => 1],
            ['name' => 'CSS', 'category' => 'Technical Skills', 'proficiency' => 92, 'sort_order' => 2],
            ['name' => 'PHP', 'category' => 'Technical Skills', 'proficiency' => 90, 'sort_order' => 3],
            ['name' => 'Laravel', 'category' => 'Technical Skills', 'proficiency' => 92, 'sort_order' => 4],
            ['name' => 'Node.js', 'category' => 'Technical Skills', 'proficiency' => 85, 'sort_order' => 5],
            ['name' => 'React.js', 'category' => 'Technical Skills', 'proficiency' => 88, 'sort_order' => 6],
            ['name' => 'Tailwind CSS', 'category' => 'Technical Skills', 'proficiency' => 90, 'sort_order' => 7],
            ['name' => 'MySQL', 'category' => 'Technical Skills', 'proficiency' => 88, 'sort_order' => 8],
            ['name' => 'Shopify', 'category' => 'Technical Skills', 'proficiency' => 80, 'sort_order' => 9],
            ['name' => 'WordPress', 'category' => 'Technical Skills', 'proficiency' => 85, 'sort_order' => 10],
            ['name' => 'Wix', 'category' => 'Technical Skills', 'proficiency' => 90, 'sort_order' => 11],
            // Soft skills
            ['name' => 'Leadership', 'category' => 'Soft Skills', 'proficiency' => 90, 'sort_order' => 12],
            ['name' => 'Communication', 'category' => 'Soft Skills', 'proficiency' => 92, 'sort_order' => 13],
            ['name' => 'Attention to Detail', 'category' => 'Soft Skills', 'proficiency' => 93, 'sort_order' => 14],
            ['name' => 'Problem Solving', 'category' => 'Soft Skills', 'proficiency' => 92, 'sort_order' => 15],
            ['name' => 'Time Management', 'category' => 'Soft Skills', 'proficiency' => 90, 'sort_order' => 16],
            ['name' => 'Adaptability', 'category' => 'Soft Skills', 'proficiency' => 91, 'sort_order' => 17],
            ['name' => 'Team Collaboration', 'category' => 'Soft Skills', 'proficiency' => 92, 'sort_order' => 18],
        ];

        foreach ($skills as $skill) {
            Skill::query()->create($skill);
        }

        $projects = [
            [
                'title' => 'Help Global',
                'description' => 'Healthcare assistance platform for medical concierge, clinics, claims support, and regional care networks across Southeast Asia.',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Tailwind'],
                'live_url' => 'https://help-global.com/',
                'github_url' => null,
                'image_gradient' => 'from-purple-200 to-purple-400',
                'image_path' => 'images/help-global.png',
                'featured' => true,
                'category' => 'development',
                'sort_order' => 1,
            ],
            [
                'title' => 'Estoria',
                'description' => 'Property management platform for listings, agents, documents, and calendars — search, filters, and status workflows in one dashboard.',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Tailwind'],
                'live_url' => 'https://estoria.mibcloud.com/login',
                'github_url' => null,
                'image_gradient' => 'from-purple-200 to-purple-400',
                'image_path' => 'images/estoria.png',
                'featured' => true,
                'category' => 'development',
                'sort_order' => 2,
            ],
            [
                'title' => 'Caza Buena',
                'description' => 'Resort booking website with a Santorini-inspired look — rooms, amenities, gallery, and stay search for Alaminos, Pangasinan.',
                'tech_stack' => ['React.js', 'Tailwind CSS', 'Laravel', 'Node.js'],
                'live_url' => 'https://darkslategray-weasel-286172.hostingersite.com/',
                'github_url' => null,
                'image_gradient' => 'from-purple-200 to-purple-400',
                'image_path' => 'images/cazabuena.png',
                'featured' => true,
                'category' => 'development',
                'sort_order' => 3,
            ],
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

        foreach ($projects as $project) {
            Project::query()->create($project);
        }

        $experiences = [
            [
                'company' => 'Juscall Insurance Agency Inc. · Makati City, Philippines',
                'role' => 'Full Stack Developer',
                'description' => "Develop and maintain internal web applications.\nDesign and implement new features to improve operational efficiency.\nManage databases and optimize application performance.\nCollaborate with stakeholders to gather requirements and deliver technical solutions.\nMaintain and update company websites and digital platforms.",
                'start_date' => '2023-12-01',
                'end_date' => null,
                'is_current' => true,
                'sort_order' => 1,
            ],
            [
                'company' => 'Buzzcube · Freelance / Remote',
                'role' => 'Website Developer',
                'description' => "Design, develop, and maintain websites using WordPress, Shopify, and Wix.\nCustomize website themes, layouts, and functionality to meet client requirements.\nOptimize website performance and responsiveness.\nCollaborate with international clients to deliver user-friendly and business-focused websites.\nTroubleshoot website issues and implement enhancements based on client feedback.",
                'start_date' => '2023-04-01',
                'end_date' => '2025-12-31',
                'is_current' => false,
                'sort_order' => 2,
            ],
            [
                'company' => 'Juscall Insurance Agency Inc. · Makati City, Philippines',
                'role' => 'Placement Associate',
                'description' => "Assisted clients in selecting appropriate insurance products based on their needs.\nProcessed insurance applications and policy documentation.\nCommunicated with clients, insurance providers, and internal teams to facilitate policy issuance.\nHandled inbound and outbound calls, responding to inquiries and providing policy updates.\nEnsured accurate record-keeping and timely resolution of client concerns.",
                'start_date' => '2020-12-01',
                'end_date' => '2022-12-31',
                'is_current' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::query()->create($experience);
        }

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
