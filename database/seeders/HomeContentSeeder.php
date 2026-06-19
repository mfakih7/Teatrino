<?php

namespace Database\Seeders;

use App\Models\HomeContent;
use App\Models\HomeFeatureCard;
use App\Support\Media\MediaUploader;
use Database\Seeders\Support\PlaceholderImageFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class HomeContentSeeder extends Seeder
{
    public function run(): void
    {
        $home = HomeContent::query()->updateOrCreate(['id' => 1], [
            'hero_title_en' => 'Welcome to Teatrino',
            'hero_title_ar' => 'مرحباً بكم في تياترينو',
            'hero_title_fr' => 'Bienvenue à Teatrino',
            'hero_subtitle_en' => 'A warm, creative nursery inspired by playful color and care.',
            'hero_subtitle_ar' => 'حضانة دافئة ومبدعة مستوحاة من الألوان المرحة والرعاية.',
            'hero_subtitle_fr' => 'Une crèche chaleureuse et créative inspirée par la couleur et le soin.',
            'hero_description_en' => 'Every day is a new adventure of art, stories, music, and gentle learning.',
            'hero_description_ar' => 'كل يوم مغامرة جديدة من الفن والقصص والموسيقى والتعلم اللطيف.',
            'hero_description_fr' => 'Chaque jour est une nouvelle aventure d\'art, d\'histoires, de musique et d\'apprentissage doux.',
            'cta_portfolio_en' => 'View Portfolio',
            'cta_portfolio_ar' => 'عرض المعرض',
            'cta_portfolio_fr' => 'Voir le portfolio',
            'cta_whatsapp_en' => 'Contact on WhatsApp',
            'cta_whatsapp_ar' => 'تواصل عبر واتساب',
            'cta_whatsapp_fr' => 'Contacter sur WhatsApp',
            'welcome_heading_en' => 'A place to grow, play, and shine',
            'welcome_heading_ar' => 'مكان للنمو واللعب والتألق',
            'welcome_heading_fr' => 'Un lieu pour grandir, jouer et briller',
            'explore_heading_en' => 'Peek into our colorful world',
            'explore_heading_ar' => 'اكتشف عالمنا الملون',
            'explore_heading_fr' => 'Découvrez notre univers coloré',
            'explore_text_en' => 'From art corners to story time, every day at Teatrino is filled with warmth, laughter, and gentle learning.',
            'explore_text_ar' => 'من ركن الفن إلى وقت الحكاية، كل يوم في تياترينو مليء بالدفء والضحك.',
            'explore_text_fr' => 'Du coin arts aux histoires, chaque journée à Teatrino est remplie de chaleur et de rires.',
        ]);

        $features = [
            ['icon' => '🎨', 'title_en' => 'Creative Play', 'title_ar' => 'لعب إبداعي', 'title_fr' => 'Jeu créatif', 'description_en' => 'Art, music, and imagination-led activities.', 'description_ar' => 'أنشطة فنية وموسيقية تحفز الخيال.', 'description_fr' => 'Art, musique et activités imaginatives.', 'sort_order' => 1],
            ['icon' => '🤗', 'title_en' => 'Warm Care', 'title_ar' => 'رعاية دافئة', 'title_fr' => 'Soins attentionnés', 'description_en' => 'A safe, nurturing environment for every child.', 'description_ar' => 'بيئة آمنة ومحبة لكل طفل.', 'description_fr' => 'Un environnement sûr et bienveillant.', 'sort_order' => 2],
            ['icon' => '🌈', 'title_en' => 'Happy Families', 'title_ar' => 'عائلات سعيدة', 'title_fr' => 'Familles heureuses', 'description_en' => 'We partner with parents to build a joyful community.', 'description_ar' => 'نتعاون مع الأهل لبناء مجتمع مبهج.', 'description_fr' => 'Nous accompagnons les parents avec joie.', 'sort_order' => 3],
        ];

        foreach ($features as $feature) {
            HomeFeatureCard::query()->updateOrCreate(
                ['title_en' => $feature['title_en']],
                array_merge($feature, ['is_active' => true])
            );
        }

        $path = PlaceholderImageFactory::create('Teatrino Hero', '#2EC4B6');
        app(MediaUploader::class)->uploadFromStoragePath($path, $home, 'hero', 'Teatrino hero');

        Cache::forget('home_content');
    }
}
