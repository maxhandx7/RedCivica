<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidato;
use App\Models\Propuesta;
use App\Models\Tarjeton;
use Carbon\Carbon;

class CandidatoSeeder extends Seeder
{
    public function run()
    {
        // Crear candidato SERPA
        $serpa = Candidato::create([
            'nombre' => 'SERPA',
            'apellido' => '',
            'alias' => 'SERPA',
            'cargo' => 'senador',
            'circunscripcion' => 'Nacional',
            'partido' => 'Un auténtico Liberal',
            'lema' => 'PROPUESTAS PARA HACER PAÍS',
            'color_principal' => '#007bff',
            'biografia' => 'Candidato al senado por la circunscripción nacional.',
            'fecha_eleccion' => '2026-03-08',
            'activo' => true,
            'orden' => 1
        ]);

        // Propuestas de SERPA
        $propuestas = [
            [
                'titulo' => 'SIN SEGURIDAD NO HAY LIBERTAD',
                'descripcion' => 'Implementaremos cámaras privadas integradas a la Policía y a empresas de seguridad, para reacción inmediata. Las Juntas de Acción Comunal tendrán acceso en tiempo real para proteger sus barrios.',
                'categoria' => 'seguridad',
                'icono' => 'fas fa-shield-alt',
                'color' => '#007bff',
                'orden' => 1,
                'destacada' => true
            ],
            [
                'titulo' => 'ICETEX JUSTO Y HUMANO',
                'descripcion' => 'Las cuotas serán proporcionales al ingreso: solo se paga cuando se trabaja. Sin empleo no hay pago, así evitamos quiebras y damos verdadera movilidad social.',
                'categoria' => 'educacion',
                'icono' => 'fas fa-graduation-cap',
                'color' => '#28a745',
                'orden' => 2,
                'destacada' => true
            ],
            [
                'titulo' => 'NO MÁS VALORIZACIONES ANTICIPADAS',
                'descripcion' => 'Obra terminada, obra pagada. Basta de exigirle a los colombianos recursos para proyectos que nunca se ejecutan. Transparencia total y control ciudadano.',
                'categoria' => 'economia',
                'icono' => 'fas fa-chart-line',
                'color' => '#ffc107',
                'orden' => 3,
                'destacada' => false
            ],
            [
                'titulo' => 'LA COMIDA NO SE BOTA',
                'descripcion' => 'Eliminaremos regulaciones irracionales que hoy obligan a desperdiciar alimentos aptos. Esa comida debe llegar a las mesas de quienes la necesitan, no a la basura.',
                'categoria' => 'social',
                'icono' => 'fas fa-hands-helping',
                'color' => '#17a2b8',
                'orden' => 4,
                'destacada' => true
            ],
            [
                'titulo' => 'PENSIÓN COMPARTIDA PARA PAREJAS PERMANENTES',
                'descripcion' => 'Mi ahorro, mi plata. Permitiremos ceder semanas entre la pareja para que uno de los dos alcance la pensión, así protegemos el patrimonio familiar.',
                'categoria' => 'economia',
                'icono' => 'fas fa-piggy-bank',
                'color' => '#ffc107',
                'orden' => 5,
                'destacada' => false
            ],
            [
                'titulo' => 'PRODUCTIVIDAD, TURISMO Y EMPLEO',
                'descripcion' => 'IVA cero en vuelos nacionales y estímulos a hotelería y restaurantes para generar empleo inmediato y dinamizar el crecimiento económico.',
                'categoria' => 'economia',
                'icono' => 'fas fa-briefcase',
                'color' => '#ffc107',
                'orden' => 6,
                'destacada' => false
            ],
            [
                'titulo' => 'VIOLADORES, NO MÁS',
                'descripcion' => 'Quien agrede no vuelve a esconderse: registro permanente e inhabilidad total. Protección real para nuestras niñas y mujeres.',
                'categoria' => 'justicia',
                'icono' => 'fas fa-balance-scale',
                'color' => '#dc3545',
                'orden' => 7,
                'destacada' => true
            ],
            [
                'titulo' => 'LÍMITES REALES AL PRESIDENTE',
                'descripcion' => 'El poder no es un cheque en blanco, más autonomía para las regiones y menos centralismo en el Palacio de Nariño, fortaleciendo instituciones y equilibrio democrático.',
                'categoria' => 'transparencia',
                'icono' => 'fas fa-eye',
                'color' => '#6f42c1',
                'orden' => 8,
                'destacada' => false
            ]
        ];

        foreach ($propuestas as $propuesta) {
            $serpa->propuestas()->create($propuesta);
        }

        // Tarjetón para SERPA
        $serpa->tarjetones()->create([
            'nombre' => 'Tarjetón para el Senado - SERPA',
            'total_opciones' => 100,
            'instruccion' => 'MARCAR MÁS DE UNA LISTA ANULA EL VOTO',
            'secciones' => [
                ['nombre' => 'PARTIDO', 'rango' => [1, 12]],
                ['nombre' => 'COLABORACIÓN', 'rango' => [13, 24]],
                ['nombre' => 'FEDERAL', 'rango' => [25, 36]],
                ['nombre' => 'PROVINCIA', 'rango' => [37, 48]],
                ['nombre' => 'DISTRITO CENTRO DEMOCRÁTICO', 'rango' => [49, 60]],
                ['nombre' => 'MUNICIPIO', 'rango' => [61, 72]],
                ['nombre' => 'CURSO', 'rango' => [73, 84]],
                ['nombre' => 'ESTUDIOS', 'rango' => [85, 96]],
                ['nombre' => 'PRIMEROS', 'rango' => [97, 100]]
            ],
            'configuracion' => [
                'mostrar_numeros' => true,
                'mostrar_nombres' => true,
                'color_primario' => '#007bff',
                'color_secundario' => '#6c757d'
            ],
            'activo' => true
        ]);

        // Crear algunos candidatos adicionales
        Candidato::factory(5)->create()->each(function ($candidato) {
            // Propuestas aleatorias
            $candidato->propuestas()->saveMany(
                Propuesta::factory(rand(3, 8))->make()
            );
            
            // Tarjetón
            $candidato->tarjetones()->save(
                Tarjeton::factory()->make()
            );
        });
    }
}