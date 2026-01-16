<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Info::truncate() ;

        $siteInfo = [
            'program' => [
                'about_program_ar' => 'عن البرنامج',
                'about_program_en' => 'about program'
            ],
        ];
        $dataToSeed = [];
        foreach ($siteInfo as $superKey => $datum) {
            foreach ($datum as $key => $item) {
                $dataToSeed[] = [
                    'super_key' => $superKey,
                    'key' => $key,
                    'value' => is_array($item) ? json_encode($item, JSON_UNESCAPED_UNICODE) : $item,
                ];
            }
        }
        Info::insert($dataToSeed);
        
    }
}
