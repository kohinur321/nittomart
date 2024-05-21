<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{

    public function run(): void
    {
        $seeting =[
           [
            'phone'=> '12345678901',
            'email'=> 'info@gmail.com',
            'address'=> 'Dhaka, Bangladesh',
            'facebook'=> 'https://www.facebook.com/',
            'twitter'=> 'https://twitter.com/',
            'instagram'=> 'https://www.instagram.com/',
            'youtube'=> 'https://www.youtube.com/',
            'logo'=> 'logo.png'
             ],
         ];

        Setting::insert($seeting);
    }
}
