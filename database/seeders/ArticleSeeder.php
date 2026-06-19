<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Support\Media\MediaUploader;
use Database\Seeders\Support\PlaceholderImageFactory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title_en' => 'First Day Tips',
                'title_ar' => 'نصائح لأول يوم',
                'title_fr' => 'Conseils pour le premier jour',
                'excerpt_en' => 'Helping your child feel confident on day one.',
                'excerpt_ar' => 'مساعدة طفلك على الشعور بالثقة في اليوم الأول.',
                'excerpt_fr' => 'Aider votre enfant à se sentir en confiance dès le premier jour.',
                'body_en' => '<p>Starting nursery is a big step. Bring a comfort item, keep goodbyes warm but brief, and trust the gentle routine our team provides.</p>',
                'body_ar' => '<p>بداية الحضانة خطوة كبيرة. أحضروا شيئاً مألوفاً للطفل، واجعلوا الوداع دافئاً ومختصراً، وثقوا بالروتين اللطيف الذي يوفره فريقنا.</p>',
                'body_fr' => '<p>Commencer la crèche est une grande étape. Apportez un objet réconfortant, des au revoir chaleureux mais brefs, et faites confiance à la routine douce de notre équipe.</p>',
                'color' => '#FFD166',
            ],
            [
                'title_en' => 'Creative Play at Home',
                'title_ar' => 'لعب إبداعي في المنزل',
                'title_fr' => 'Jeu créatif à la maison',
                'excerpt_en' => 'Simple art ideas you can try this weekend.',
                'excerpt_ar' => 'أفكار فنية بسيطة يمكنكم تجربتها في عطلة نهاية الأسبوع.',
                'excerpt_fr' => 'Des idées artistiques simples à essayer ce week-end.',
                'body_en' => '<p>Use recycled boxes, finger paints, and music to extend the Teatrino spirit at home.</p>',
                'body_ar' => '<p>استخدموا الصناديق المعاد تدويرها وألوان الأصابع والموسيقى لنقل روح تياترينو إلى المنزل.</p>',
                'body_fr' => '<p>Utilisez des boîtes recyclées, de la peinture à doigts et de la musique pour prolonger l\'esprit Teatrino à la maison.</p>',
                'color' => '#2EC4B6',
            ],
            [
                'title_en' => 'Healthy Snacks Kids Love',
                'title_ar' => 'وجبات خفيفة صحية يحبها الأطفال',
                'title_fr' => 'Collations saines que les enfants adorent',
                'excerpt_en' => 'Colorful, balanced snack ideas for busy families.',
                'excerpt_ar' => 'أفكار وجبات خفيفة ملونة ومتوازنة للعائلات المشغولة.',
                'excerpt_fr' => 'Des idées de collations colorées et équilibrées pour les familles occupées.',
                'body_en' => '<p>Think fruit rainbows, yogurt parfaits, and veggie dips shaped like smiles.</p>',
                'body_ar' => '<p>فكروا في قوس قزح من الفواكه، وطبقات الزبادي، وصلصات الخضار على شكل ابتسامات.</p>',
                'body_fr' => '<p>Pensez aux arcs-en-ciel de fruits, aux parfaits au yaourt et aux dips de légumes en forme de sourires.</p>',
                'color' => '#E76F51',
            ],
            [
                'title_en' => 'Building Routines',
                'title_ar' => 'بناء الروتين اليومي',
                'title_fr' => 'Construire des routines',
                'excerpt_en' => 'Why gentle routines help little ones thrive.',
                'excerpt_ar' => 'لماذا تساعد الروتينات اللطيفة الصغار على الازدهار.',
                'excerpt_fr' => 'Pourquoi des routines douces aident les tout-petits à s\'épanouir.',
                'body_en' => '<p>Predictable rhythms for meals, rest, and play create a sense of safety and joy.</p>',
                'body_ar' => '<p>إيقاعات متوقعة للوجبات والراحة واللعب تخلق شعوراً بالأمان والفرح.</p>',
                'body_fr' => '<p>Des rythmes prévisibles pour les repas, le repos et le jeu créent un sentiment de sécurité et de joie.</p>',
                'color' => '#A8DADC',
            ],
            [
                'title_en' => 'Meet Our Teachers',
                'title_ar' => 'تعرفوا على معلمينا',
                'title_fr' => 'Rencontrez nos éducatrices',
                'excerpt_en' => 'The caring team behind Teatrino.',
                'excerpt_ar' => 'الفريق المهتم الذي يقف وراء تياترينو.',
                'excerpt_fr' => 'L\'équipe attentionnée derrière Teatrino.',
                'body_en' => '<p>Our educators bring patience, creativity, and years of early-years experience.</p>',
                'body_ar' => '<p>مربّونا يجلبون الصبر والإبداع وسنوات من الخبرة في مرحلة الطفولة المبكرة.</p>',
                'body_fr' => '<p>Nos éducatrices apportent patience, créativité et des années d\'expérience en petite enfance.</p>',
                'color' => '#FFB4A2',
            ],
            [
                'title_en' => 'Spring Newsletter',
                'title_ar' => 'نشرة الربيع',
                'title_fr' => 'Bulletin de printemps',
                'excerpt_en' => 'Highlights from our colorful spring season.',
                'excerpt_ar' => 'أبرز لحظات موسم الربيع الملون لدينا.',
                'excerpt_fr' => 'Les temps forts de notre saison printanière colorée.',
                'body_en' => '<p>From garden projects to umbrella day celebrations, spring has been wonderful at Teatrino.</p>',
                'body_ar' => '<p>من مشاريع الحديقة إلى احتفالات يوم المظلة، كان الربيع رائعاً في تياترينو.</p>',
                'body_fr' => '<p>Des projets de jardin aux célébrations du jour du parapluie, le printemps a été merveilleux à Teatrino.</p>',
                'color' => '#FFD166',
            ],
        ];

        foreach ($articles as $index => $data) {
            $article = Article::query()->updateOrCreate(
                ['title_en' => $data['title_en']],
                [
                    'title_ar' => $data['title_ar'],
                    'title_fr' => $data['title_fr'],
                    'excerpt_en' => $data['excerpt_en'],
                    'excerpt_ar' => $data['excerpt_ar'],
                    'excerpt_fr' => $data['excerpt_fr'],
                    'body_en' => $data['body_en'],
                    'body_ar' => $data['body_ar'],
                    'body_fr' => $data['body_fr'],
                    'published_at' => now()->subDays(6 - $index),
                    'is_active' => true,
                ]
            );

            if (! $article->featuredImage()) {
                $path = PlaceholderImageFactory::create($data['title_en'], $data['color']);
                app(MediaUploader::class)->uploadFromStoragePath($path, $article, 'article', $data['title_en']);
            }
        }
    }
}
