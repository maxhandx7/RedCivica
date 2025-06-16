<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
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
            'name' => "Campaña precidencial 2026",
            'description' => "Esto es un ejemplo",
            'image' => "system/default.jpg",
        ]);
    }
}
