<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            [
                'key' => '01',
                'ar_name' => 'دمشق',
                'en_name' => 'Damascus',
            ],
            [
                'key' => '02',
                'ar_name' => 'حلب',
                'en_name' => 'Aleppo',
            ],
            [
                'key' => '03',
                'ar_name' => 'ريف دمشق',
                'en_name' => 'Damascus Countryside',
            ],
            [
                'key' => '04',
                'ar_name' => 'حمص',
                'en_name' => 'Homs',
            ],
            [
                'key' => '05',
                'ar_name' => 'حماة',
                'en_name' => 'Hama',
            ],
            [
                'key' => '06',
                'ar_name' => 'اللاذقية',
                'en_name' => 'Latakia',
            ],
            [
                'key' => '07',
                'ar_name' => 'إدلب',
                'en_name' => 'Idlib',
            ],
            [
                'key' => '08',
                'ar_name' => 'الحسكة',
                'en_name' => 'Hasakah',
            ],
            [
                'key' => '09',
                'ar_name' => 'دير الزور',
                'en_name' => 'Deir Ezzor',
            ],
            [
                'key' => '10',
                'ar_name' => 'طرطوس',
                'en_name' => 'Tartous',
            ],
            [
                'key' => '11',
                'ar_name' => 'الرقة',
                'en_name' => 'Raqqa',
            ],
            [
                'key' => '12',
                'ar_name' => 'درعا',
                'en_name' => 'Daraa',
            ],
            [
                'key' => '13',
                'ar_name' => 'السويداء',
                'en_name' => 'Sweida',
            ],
            [
                'key' => '14',
                'ar_name' => 'القنيطرة',
                'en_name' => 'Quneitra',
            ],
            [
                'key' => '9',
                'ar_name' => 'السوريين الفلسطينيين',
                'en_name' => 'Syrian Palestinians',
            ],
        ];
        Province::insert($provinces);
    }
}
