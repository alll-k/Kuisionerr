<?php

namespace Database\Seeders;

use App\Models\SdgGoal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SdgGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            ['number' => 1, 'title' => 'No Poverty', 'description' => 'Menghilangkan segala bentuk kemiskinan'],
            ['number' => 2, 'title' => 'Zero Hunger', 'description' => 'Menghilangkan kelaparan dan meningkatkan ketahanan pangan'],
            ['number' => 3, 'title' => 'Good Health and Well-Being', 'description' => 'Menjamin kehidupan sehat dan meningkatkan kesejahteraan'],
            ['number' => 4, 'title' => 'Quality Education', 'description' => 'Menjamin pendidikan berkualitas yang inklusif'],
            ['number' => 5, 'title' => 'Gender Equality', 'description' => 'Mencapai kesetaraan gender dan memberdayakan semua perempuan'],
            ['number' => 6, 'title' => 'Clean Water and Sanitation', 'description' => 'Menjamin ketersediaan dan pengelolaan air bersih dan sanitasi'],
            ['number' => 7, 'title' => 'Affordable and Clean Energy', 'description' => 'Menjamin akses energi modern yang terjangkau dan berkelanjutan'],
            ['number' => 8, 'title' => 'Decent Work and Economic Growth', 'description' => 'Meningkatkan pertumbuhan ekonomi dan kesempatan kerja layak'],
            ['number' => 9, 'title' => 'Industry, Innovation and Infrastructure', 'description' => 'Membangun infrastruktur tangguh dan mendorong inovasi'],
            ['number' => 10, 'title' => 'Reduced Inequalities', 'description' => 'Mengurangi ketimpangan dalam dan antar negara'],
            ['number' => 11, 'title' => 'Sustainable Cities and Communities', 'description' => 'Menjadikan kota dan komunitas aman dan berkelanjutan'],
            ['number' => 12, 'title' => 'Responsible Consumption and Production', 'description' => 'Menjamin pola produksi dan konsumsi berkelanjutan'],
            ['number' => 13, 'title' => 'Climate Action', 'description' => 'Menangani perubahan iklim dan dampaknya'],
            ['number' => 14, 'title' => 'Life Below Water', 'description' => 'Melestarikan dan memanfaatkan laut, lautan dan sumber daya laut'],
            ['number' => 15, 'title' => 'Life on Land', 'description' => 'Melindungi, memulihkan dan meningkatkan pemanfaatan ekosistem darat'],
            ['number' => 16, 'title' => 'Peace, Justice and Strong Institutions', 'description' => 'Mempromosikan perdamaian dan keadilan melalui institusi yang kuat'],
            ['number' => 17, 'title' => 'Partnerships for the Goals', 'description' => 'Memperkuat sarana implementasi dan kemitraan global'],
        ];

        foreach ($goals as $goal) {
            SdgGoal::create($goal);
        }
    }
}
