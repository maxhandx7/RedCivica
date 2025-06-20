<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Campaña;


class CampañaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaña::create([
            'name' => "Sitio web",
            'slug' => Str::slug('campaña', '_'), 
            'description' => "Usuarios ingresados por el sistema",
            'image' => "system/default.jpg",
        ]);
    }
}
