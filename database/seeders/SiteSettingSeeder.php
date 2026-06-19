<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->updateOrCreate(['id' => 1], [
            'website_name_en' => 'Teatrino',
            'website_name_ar' => 'تياترينو',
            'website_name_fr' => 'Teatrino',
            'email' => 'admin@teatrino.com',
            'whatsapp_number' => '96170000000',
            'whatsapp_message' => 'Hello Teatrino! I would like to know more about your nursery.',
            'social_facebook' => 'https://facebook.com/teatrino',
            'social_instagram' => 'https://instagram.com/teatrino',
            'footer_text_en' => 'A colorful nursery where little imaginations bloom.',
            'footer_text_ar' => 'حضانة ملونة حيث تتفتح الخيالات الصغيرة.',
            'footer_text_fr' => 'Une crèche colorée où les petites imaginations s\'épanouissent.',
            'contact_title_en' => 'We would love to hear from you',
            'contact_title_ar' => 'يسعدنا التواصل معكم',
            'contact_title_fr' => 'Nous serions ravis d\'échanger avec vous',
            'contact_description_en' => 'Reach out for visits, enrollment questions, or a friendly chat about your little one.',
            'contact_description_ar' => 'تواصلوا معنا للزيارات أو التسجيل أو لأي استفسار عن أطفالكم.',
            'contact_description_fr' => 'Contactez-nous pour une visite, une inscription ou toute question sur votre enfant.',
        ]);
    }
}
