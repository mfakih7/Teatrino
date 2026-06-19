<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Support\Media\MediaUploader;
use Database\Seeders\Support\PlaceholderImageFactory;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name_en' => 'Sarah Mitchell',
                'name_ar' => 'سارة ميتشل',
                'name_fr' => 'Sarah Mitchell',
                'position_en' => 'Class Teacher',
                'position_ar' => 'معلمة الصف',
                'position_fr' => 'Enseignante de classe',
                'description_en' => 'Sarah brings twelve years of early childhood experience and a gentle, playful approach that helps little ones feel safe and excited to learn.',
                'description_ar' => 'تتمتع سارة باثني عشر عاماً من الخبرة في الطفولة المبكرة، وتتبع أسلوباً لطيفاً وممتعاً يساعد الصغار على الشعور بالأمان والحماس للتعلم.',
                'description_fr' => 'Sarah apporte douze ans d\'expérience en petite enfance et une approche douce et ludique qui rassure les enfants.',
                'education_en' => 'BA Early Childhood Education, Montessori Certified',
                'education_ar' => 'بكالوريوس تربية الطفولة المبكرة، شهادة مونتيسوري',
                'education_fr' => 'Licence en petite enfance, certifiée Montessori',
                'color' => '#2EC4B6',
            ],
            [
                'name_en' => 'Layla Hassan',
                'name_ar' => 'ليلى حسن',
                'name_fr' => 'Layla Hassan',
                'position_en' => 'Nursery Assistant',
                'position_ar' => 'مساعدة الحضانة',
                'position_fr' => 'Assistante de crèche',
                'description_en' => 'Layla is known for her warm hugs, patient listening, and the calm routines that help toddlers settle happily into nursery life.',
                'description_ar' => 'تشتهر ليلى بعناقها الدافئ وصبرها في الاستماع والروتين الهادئ الذي يساعد الأطفال على التأقلم بسعادة مع الحضانة.',
                'description_fr' => 'Layla est appréciée pour sa douceur, sa patience et les routines apaisantes qui aident les tout-petits à s\'épanouir.',
                'education_en' => 'Diploma in Child Care & Development',
                'education_ar' => 'دبلوم رعاية وتطوير الطفل',
                'education_fr' => 'Diplôme en puériculture et développement de l\'enfant',
                'color' => '#FFD166',
            ],
            [
                'name_en' => 'Marie Dubois',
                'name_ar' => 'ماري دوبوا',
                'name_fr' => 'Marie Dubois',
                'position_en' => 'Art Teacher',
                'position_ar' => 'معلمة الفن',
                'position_fr' => 'Professeure d\'arts',
                'description_en' => 'Marie fills our art corner with color, curiosity, and messy masterpieces that celebrate every child\'s unique imagination.',
                'description_ar' => 'تملأ ماري ركن الفن بالألوان والفضول والإبداعات الصغيرة التي تحتفي بخيال كل طفل.',
                'description_fr' => 'Marie remplit notre coin arts de couleurs, de curiosité et de créations qui célèbrent l\'imagination de chaque enfant.',
                'education_en' => 'MA Visual Arts Education',
                'education_ar' => 'ماجستير تعليم الفنون البصرية',
                'education_fr' => 'Master en enseignement des arts visuels',
                'color' => '#E76F51',
            ],
            [
                'name_en' => 'Ahmed Al-Rashid',
                'name_ar' => 'أحمد الراشد',
                'name_fr' => 'Ahmed Al-Rashid',
                'position_en' => 'Music Teacher',
                'position_ar' => 'معلم الموسيقى',
                'position_fr' => 'Professeur de musique',
                'description_en' => 'Ahmed leads joyful music circles with rhythm, songs, and movement that build confidence and happy memories.',
                'description_ar' => 'يقود أحمد حلقات موسيقية مبهجة بالإيقاع والأغاني والحركة لتعزيز الثقة وصنع ذكريات سعيدة.',
                'description_fr' => 'Ahmed anime des cercles musicaux joyeux avec rythme, chansons et mouvement pour renforcer la confiance des enfants.',
                'education_en' => 'BA Music Education, Orff Approach Training',
                'education_ar' => 'بكالوريوس تعليم الموسيقى، تدريب منهج أورف',
                'education_fr' => 'Licence en éducation musicale, formation approche Orff',
                'color' => '#A8DADC',
            ],
        ];

        foreach ($teachers as $index => $item) {
            $teacher = Teacher::query()->updateOrCreate(
                ['name_en' => $item['name_en']],
                [
                    'name_ar' => $item['name_ar'],
                    'name_fr' => $item['name_fr'],
                    'position_en' => $item['position_en'],
                    'position_ar' => $item['position_ar'],
                    'position_fr' => $item['position_fr'],
                    'description_en' => $item['description_en'],
                    'description_ar' => $item['description_ar'],
                    'description_fr' => $item['description_fr'],
                    'education_en' => $item['education_en'],
                    'education_ar' => $item['education_ar'],
                    'education_fr' => $item['education_fr'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );

            if (! $teacher->image()) {
                $path = PlaceholderImageFactory::create($item['name_en'], $item['color']);
                app(MediaUploader::class)->uploadFromStoragePath($path, $teacher, 'teacher', $item['name_en']);
            }
        }
    }
}
