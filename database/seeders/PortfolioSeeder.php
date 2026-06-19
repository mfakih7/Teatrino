<?php

namespace Database\Seeders;

use App\Models\PortfolioItem;
use App\Support\Media\MediaUploader;
use Database\Seeders\Support\PlaceholderImageFactory;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title_en' => 'Art Corner', 'title_ar' => 'ركن الفن', 'title_fr' => 'Coin arts', 'description_en' => 'Little hands painting rainbows and sunshine.', 'description_ar' => 'أيدٍ صغيرة ترسم قوس قزح والشمس.', 'description_fr' => 'Petites mains qui peignent des arcs-en-ciel.', 'color' => '#FFD166'],
            ['title_en' => 'Music & Movement', 'title_ar' => 'موسيقى وحركة', 'title_fr' => 'Musique et mouvement', 'description_en' => 'Rhythm, dance, and joyful sounds fill our mornings.', 'description_ar' => 'إيقاع ورقص وأصوات مبهجة تملأ صباحنا.', 'description_fr' => 'Rythme, danse et sons joyeux le matin.', 'color' => '#2EC4B6'],
            ['title_en' => 'Garden Discovery', 'title_ar' => 'اكتشاف الحديقة', 'title_fr' => 'Découverte du jardin', 'description_en' => 'Exploring nature with wonder and gentle care.', 'description_ar' => 'استكشاف الطبيعة بدهشة ورعاية لطيفة.', 'description_fr' => 'Explorer la nature avec émerveillement.', 'color' => '#E76F51'],
            ['title_en' => 'Story Circle', 'title_ar' => 'حلقة الحكاية', 'title_fr' => 'Cercle de lecture', 'description_en' => 'Cozy story time that sparks big imaginations.', 'description_ar' => 'وقت حكاية دافئ يشعل الخيال.', 'description_fr' => 'Un moment lecture qui éveille l\'imagination.', 'color' => '#FFB4A2'],
        ];

        foreach ($items as $index => $item) {
            $portfolio = PortfolioItem::query()->updateOrCreate(
                ['title_en' => $item['title_en']],
                [
                    'title_ar' => $item['title_ar'],
                    'title_fr' => $item['title_fr'],
                    'description_en' => $item['description_en'],
                    'description_ar' => $item['description_ar'],
                    'description_fr' => $item['description_fr'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            if (! $portfolio->image()) {
                $path = PlaceholderImageFactory::create($item['title_en'], $item['color']);
                app(MediaUploader::class)->uploadFromStoragePath($path, $portfolio, 'portfolio', $item['title_en']);
            }
        }
    }
}
