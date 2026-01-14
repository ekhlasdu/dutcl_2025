<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Department of Bangla',
            'Department of English',
            'Department of Arabic',
            'Department of Persian Language & Literature',
            'Department of Urdu',
            'Department of Sanskrit',
            'Department of Pali & Buddhist Studies',
            'Department of Linguistics',
            'Department of Philosophy',
            'Department of History',
            'Department of Islamic Studies',
            'Department of Islamic History & Culture',
            'Department of Information Science & Library Management',
            'Department of Theatre & Performance Studies',
            'Department of Music',
            'Department of Dance',
            'Department of World Religions & Culture',
            'Department of Economics',
            'Department of Political Science',
            'Department of International Relations',
            'Department of Anthropology',
            'Department of Public Administration',
            'Department of Mass Communication & Journalism',
            'Department of Communication Disorders',
            'Department of Printing & Publication Studies',
            'Department of Television, Film & Photography',
            'Department of Sociology',
            'Department of Development Studies',
            'Department of Criminology',
            'Department of Japanese Studies',
            'Department of Women & Gender Studies',
            'Department of Peace & Conflict Studies',
            'Department of Law',
            'Department of Ceramics',
            'Department of Craft',
            'Department of Drawing & Painting',
            'Department of Graphic Design',
            'Department of Oriental Art',
            'Department of Printmaking',
            'Department of Sculpture',
            'Department of History of Art',
            'Department of Accounting & Information Systems',
            'Department of Management',
            'Department of Marketing',
            'Department of Finance',
            'Department of Banking & Insurance',
            'Department of Management Information Systems',
            'Department of International Business',
            'Department of Tourism & Hospitality Management',
            'Department of Organization Strategy & Leadership',
            'Department of Mathematics',
            'Department of Applied Mathematics',
            'Department of Physics',
            'Department of Chemistry',
            'Department of Statistics',
            'Department of Biomedical Physics & Technology',
            'Department of Theoretical Physics',
            'Department of Theoretical & Computational Chemistry',
            'Department of Pharmacy',
            'Department of Clinical Pharmacy & Pharmacology',
            'Department of Pharmaceutical Chemistry',
            'Department of Pharmaceutical Technology',
            'Department of Botany',
            'Department of Zoology',
            'Department of Biochemistry & Molecular Biology',
            'Department of Microbiology',
            'Department of Psychology',
            'Department of Medical Psychology',
            'Department of Educational Psychology',
            'Department of Genetic Engineering & Biotechnology',
            'Department of Soil, Water & Environment',
            'Department of Fisheries',
            'Department of Geography & Environment',
            'Department of Geology',
            'Department of Oceanography',
            'Department of Disaster Science & Climate Resilience',
            'Department of Meteorology',
            'Department of Electrical & Electronic Engineering',
            'Department of Applied Chemistry & Chemical Engineering',
            'Department of Computer Science & Engineering',
            'Department of Nuclear Engineering',
            'Department of Robotics & Mechatronics Engineering',
            'Department of Institute of Education and Research',
            'Department of Institute of Statistical Research & Training',
            'Department of Institute of Business Administration',
            'Department of Institute of Nutrition & Food Science',
            'Department of Institute of Social Welfare & Research',
            'Department of Institute of Modern Languages',
            'Department of Institute of Information Technology',
            'Department of Institute of Leather Engineering & Technology',
            'Department of Institute of Health Economics'
        ];

        foreach ($departments as $name) {
            DB::table('departments')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
