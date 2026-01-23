<?php

namespace App\Exports;

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $controller = app(DashboardController::class);

        $clients = auth()->user()->descendantsAndSelf()->depthFirst()->get();

        $ciudad = $controller->getCityName($clients);
        $ciudad = $ciudad->toArray();
        foreach ($clients as $index => $client) {
            $client->ciudad = $ciudad[$index];
        }

        $departamento = $controller->getDepName($clients);
        $departamento = $departamento->toArray();
        foreach ($clients as $index => $client) {
            $client->departamento = $departamento[$index];
        }

        $data = $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'cedula' => $client->cedula,
                'name' => $client->name,
                'surname' => $client->surname,
                'fecha_nacimiento' => $client->fecha_nacimiento,
                'edad' => Carbon::parse($client->fecha_nacimiento)->age,
                'email' => $client->email,
                'telefono' => $client->telefono,
                'pais' => 'Colombia',
                'departamento' => $client->departamento,
                'ciudad' => $client->ciudad,
                'comuna' => $client->comuna,
                'barrio' => $client->barrio,
                'direccion' => $client->direccion,
                'estado' => $client->estado,
                'created_at' => Carbon::parse($client->created_at)->translatedFormat('d \d\e F \d\e Y'),
            ];
        });
        return $data;
        ;
    }


    public function headings(): array
    {
        return [
            'ID',
            'Cédula',
            'Nombre',
            'Apellido',
            'Fecha de Nacimiento',
            'Edad',
            'Correo',
            'Teléfono',
            'País',
            'Departamento',
            'Ciudad',
            'Comuna',
            'Barrio',
            'Dirección',
            'Estado',
            'Fecha de Registro',
        ];
    }
}
