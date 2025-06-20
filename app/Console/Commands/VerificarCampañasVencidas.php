<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaña;

class VerificarCampañasVencidas extends Command
{
    protected $signature = 'campañas:verificar-fecha';
    protected $description = 'Cambia el estado a inactivo si la fecha_fin ya pasó';

    public function handle()
    {
        $hoy = now();

        $vencidas = Campaña::where('estado', 'activo')
            ->whereDate('fecha_fin', '<', $hoy)
            ->update(['estado' => 'inactivo']);

        $this->info("Campañas actualizadas: $vencidas");
    }
}
