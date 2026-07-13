<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Database\Seeder;

/**
 * Sync Experience & Skills from resume data without wiping projects/profile.
 */
class ResumeExperienceSkillsSeeder extends Seeder
{
    public function run(): void
    {
        Skill::query()->delete();
        Experience::query()->delete();

        $skills = [
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
    }
}
