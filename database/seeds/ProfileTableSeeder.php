<?php

use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'name' => 'profile',
            'display_name' => 'Profile'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'update-own-profile',
                'display_name' => 'Update Own',
                'description' => 'Profile Update Own',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-all-profile',
                'display_name' => 'Update All',
                'description' => 'Profile Update All',
                'module_id' => $moduleId
            ],
        ]);

        // Lists
        DB::table('profile_list_contacts')->insert([
            ['title' => 'mail'],
            ['title' => 'phone'],
            ['title' => 'cellphone']
        ]);

        DB::table('profile_list_departments')->insert([
            ['title' => 'Accounting and Finance'],
            ['title' => 'Human Resource Management'],
            ['title' => 'Marketing'],
            ['title' => 'Purchasing'],
            ['title' => 'Production'],
            ['title' => 'Research and Development'],
        ]);

        DB::table('profile_list_genders')->insert([
            ['title' => 'female'],
            ['title' => 'male']
        ]);

        DB::table('profile_list_positions')->insert([
            ['title' => 'SEO'],
            ['title' => 'Digital Marketing Manager'],
            ['title' => 'Social Media Manager'],
            ['title' => 'Scrum Master'],
            ['title' => 'Product Owner'],
            ['title' => 'Social Media + Marketing'],
            ['title' => 'Frontend Developer'],
            ['title' => 'Backend Developer'],
            ['title' => 'Full-stack Developer'],
            ['title' => 'UX Designer'],
            ['title' => 'UI Designer'],
            ['title' => 'Devops Manager']

        ]);

        DB::table('profile_list_professions')->insert([
            ['title' => 'Developer'],
            ['title' => 'Designer'],
            ['title' => 'Software Architect']
        ]);

        DB::table('profile_list_relations')->insert([
            ['title' => 'father'],
            ['title' => 'mother'],
            ['title' => 'son'],
            ['title' => 'daughter'],
            ['title' => 'brother'],
            ['title' => 'sister'],
            ['title' => 'wife'],
            ['title' => 'husband'],
        ]);

        DB::table('profile_list_relationships')->insert([
            ['title' => 'single'],
            ['title' => 'married'],
            ['title' => 'commited'],
            ['title' => 'separate'],
            ['title' => 'divorced'],
            ['title' => 'widower']
        ]);
    }
}
