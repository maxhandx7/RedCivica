<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CampañaSeeder::class);

         // Primero creamos 100 usuarios referidores (sin padres)
         /* $referrers = User::factory()->count(100)->create();
         echo "Creados 100 usuarios referidores\n";

         $batchSize = 100;
         $totalUsers = 1000;

         for ($i = 0; $i < $totalUsers / $batchSize; $i++) {
             $users = User::factory()->count($batchSize)->create([
                 // Asigna un parent_id aleatorio de los referidores existentes
                 'parent_id' => $referrers->random()->id
             ]);

             // Añadimos los nuevos usuarios a los posibles referidores
             if($i % 3 === 0) { // Cada 3 lotes, añadimos más referidores
                 $referrers = $referrers->merge($users->random(100));
             }

             echo "Creado lote #" . ($i + 1) . " de " . ($totalUsers / $batchSize) . "\n";
         }

         // Usuario no verificado con referidor
         User::factory()
             ->unverified()
             ->withReferrer()
             ->create(); */
    }
}
