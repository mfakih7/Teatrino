<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\NurseryParent;
use App\Support\Media\InlineImageService;
use Database\Seeders\Support\PlaceholderImageFactory;
use Illuminate\Database\Seeder;

class NurseryFamilySeeder extends Seeder
{
    public function run(): void
    {
        $families = [
            [
                'parent' => [
                    'full_name' => 'Rana Khoury',
                    'phone_number' => '96170111222',
                    'whatsapp_number' => '96170111222',
                    'address' => 'Achrafieh, Beirut',
                    'emergency_contact_name' => 'Joseph Khoury',
                    'emergency_contact_phone' => '96170999888',
                    'notes' => 'Prefers WhatsApp updates in the afternoon.',
                ],
                'children' => [
                    ['full_name' => 'Maya Khoury', 'gender' => 'female', 'class_name' => 'Butterflies', 'date_of_birth' => '2022-03-14', 'allergies' => 'Peanuts'],
                    ['full_name' => 'Adam Khoury', 'gender' => 'male', 'class_name' => 'Sunshine', 'date_of_birth' => '2023-08-02'],
                ],
            ],
            [
                'parent' => [
                    'full_name' => 'Nadine Haddad',
                    'phone_number' => '96170333444',
                    'whatsapp_number' => '96170333444',
                    'address' => 'Jounieh',
                    'emergency_contact_name' => 'George Haddad',
                    'emergency_contact_phone' => '96170888777',
                    'notes' => 'Mother picks up on weekdays; grandmother on Fridays.',
                ],
                'children' => [
                    ['full_name' => 'Lara Haddad', 'gender' => 'female', 'class_name' => 'Rainbows', 'date_of_birth' => '2021-11-20', 'special_notes' => 'Loves painting and music time.'],
                ],
            ],
            [
                'parent' => [
                    'full_name' => 'Karim Saab',
                    'phone_number' => '96170555666',
                    'whatsapp_number' => null,
                    'address' => 'Dbayeh',
                    'emergency_contact_name' => 'Mireille Saab',
                    'emergency_contact_phone' => '96170123456',
                    'notes' => 'Call before 6 PM if urgent.',
                ],
                'children' => [
                    ['full_name' => 'Omar Saab', 'gender' => 'male', 'class_name' => 'Explorers', 'date_of_birth' => '2020-05-09'],
                    ['full_name' => 'Yara Saab', 'gender' => 'female', 'class_name' => 'Butterflies', 'date_of_birth' => '2022-12-01'],
                    ['full_name' => 'Noah Saab', 'gender' => 'male', 'class_name' => 'Sunshine', 'date_of_birth' => '2024-01-18', 'health_notes' => 'Mild asthma — inhaler kept at front desk.'],
                ],
            ],
            [
                'parent' => [
                    'full_name' => 'Sara Mansour',
                    'phone_number' => '96170777888',
                    'whatsapp_number' => '96170777888',
                    'address' => 'Antelias',
                    'emergency_contact_name' => 'Tony Mansour',
                    'emergency_contact_phone' => '96170321098',
                    'notes' => 'New family — started this term.',
                ],
                'children' => [
                    ['full_name' => 'Jad Mansour', 'gender' => 'male', 'class_name' => 'Sunshine', 'date_of_birth' => '2023-04-27'],
                ],
            ],
            [
                'parent' => [
                    'full_name' => 'Elie and Marie Fares',
                    'phone_number' => '96170999000',
                    'whatsapp_number' => '96170999000',
                    'address' => 'Hazmieh',
                    'emergency_contact_name' => 'Marie Fares',
                    'emergency_contact_phone' => '96170999001',
                    'notes' => 'Twins enrolled together; please keep them in the same activity groups when possible.',
                ],
                'children' => [
                    ['full_name' => 'Nour Fares', 'gender' => 'female', 'class_name' => 'Rainbows', 'date_of_birth' => '2022-07-15'],
                    ['full_name' => 'Tia Fares', 'gender' => 'female', 'class_name' => 'Rainbows', 'date_of_birth' => '2022-07-15'],
                ],
            ],
        ];

        $colors = ['#FFD166', '#2EC4B6', '#E76F51', '#A8DADC', '#FFB4A2'];
        $imageService = app(InlineImageService::class);

        foreach ($families as $index => $family) {
            $parent = NurseryParent::query()->updateOrCreate(
                ['phone_number' => $family['parent']['phone_number']],
                array_merge($family['parent'], ['is_active' => true])
            );

            foreach ($family['children'] as $childIndex => $childData) {
                $child = Child::query()->updateOrCreate(
                    [
                        'parent_id' => $parent->id,
                        'full_name' => $childData['full_name'],
                    ],
                    array_merge($childData, ['is_active' => true])
                );

                if (! $child->profile_photo_thumbnail_path) {
                    $path = PlaceholderImageFactory::create($childData['full_name'], $colors[($index + $childIndex) % count($colors)]);
                    $imageService->syncFromStoragePath(
                        $child,
                        'profile_photo',
                        $path,
                        trim(config('media.base_path'), '/').'/children/'.$child->id
                    );
                }
            }
        }
    }
}
