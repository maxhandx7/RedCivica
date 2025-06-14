<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;


class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::create([
            'name'=>'AF',
            'description'=>'No description',
            'logo'=>'system/default.jpg',
            'mail'=>'contacto@afdeveloper.com',
            'address'=>' Cali, Colombia',
            'phone' => '+573145561727',
            'nit'=>'1-143982071',
        ]);
    }
}
