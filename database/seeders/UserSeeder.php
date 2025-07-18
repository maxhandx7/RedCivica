<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "Alan",
            'surname' => "Carabali",
            'email' => "Alancarabali@gmail.com",
            'cedula' => "1143982071",
            'telefono' => "3145561727",
            'barrio' => "puertas del sol",
            'direccion' => "calle 1 # 2-3",
            'ciudad' => "Cali",
            'estado' => "Activo",
            'image' => "https://unsplash.it/400/200",
            'departamento' => "Valle del Cauca",
            'pais' => "Colombia",
            'mesa' => "A117",
            'email_verified_at' => now(),
            'password' => Hash::make('17964290'),
            'parent_id' => null,
            'business_id' => 1,
        ]);

        $user->assignRole("admin");
    }


}
