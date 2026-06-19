<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            HomeContentSeeder::class,
            AboutPageSeeder::class,
            TeacherSeeder::class,
            PortfolioSeeder::class,
            ArticleSeeder::class,
            NurseryFamilySeeder::class,
            PaymentSeeder::class,
            WeeklyReportSeeder::class,
        ]);
    }
}
