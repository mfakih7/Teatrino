<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use App\Support\Media\MediaUploader;
use Database\Seeders\Support\PlaceholderImageFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $about = AboutPage::query()->updateOrCreate(['id' => 1], [
            'title_en' => 'About Teatrino',
            'title_ar' => 'عن تياترينو',
            'title_fr' => 'À propos de Teatrino',
            'body_en' => '<p>Teatrino began with a simple dream: a nursery that feels like a rainbow umbrella on a sunny day — colorful, protective, and full of joy.</p><p>We create spaces where children explore, create, and build confidence through play.</p>',
            'body_ar' => '<p>بدأت تياترينو بحلم بسيط: حضانة تشبه مظلة قوس قزح في يوم مشمس — ملونة، آمنة، ومليئة بالفرح.</p>',
            'body_fr' => '<p>Teatrino est né d\'un rêve simple : une crèche colorée comme un parapluie arc-en-ciel — joyeuse et protectrice.</p>',
            'mission_en' => 'To nurture curiosity, kindness, and creativity in every child.',
            'mission_ar' => 'تنمية الفضول واللطف والإبداع لدى كل طفل.',
            'mission_fr' => 'Éveiller la curiosité, la gentillesse et la créativité de chaque enfant.',
            'vision_en' => 'A community where families and educators grow together under one colorful umbrella.',
            'vision_ar' => 'مجتمع يكبر فيه الأهل والمربون معاً تحت مظلة ملونة واحدة.',
            'vision_fr' => 'Une communauté où familles et éducateurs grandissent ensemble.',
            'is_active' => true,
        ]);

        $uploader = app(MediaUploader::class);
        $colors = ['#FFD166', '#E76F51', '#A8DADC'];

        foreach (['Our Classroom', 'Story Time', 'Outdoor Play'] as $index => $label) {
            $path = PlaceholderImageFactory::create($label, $colors[$index]);
            $uploader->uploadFromStoragePath($path, $about, 'gallery', $label, $index, false);
        }

        Cache::forget('about_page');
    }
}
