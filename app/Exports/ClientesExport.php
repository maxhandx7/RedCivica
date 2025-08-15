<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $clients = auth()->user()->descendantsAndSelf()->depthFirst()->get();

        $data = $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'cedula' => $client->cedula,
                'name' => $client->name,
                'surname' => $client->surname,
                'email' => $client->email,
                'telefono' => $client->telefono,
                'direccion' => $client->direccion,
                'ciudad' => $client->ciudad,
                'departamento' => $client->departamento,
                'pais' => $client->pais,
                'barrio' => $client->barrio,
                'estado' => $client->estado,
                'created_at' => $client->created_at->format('Y-m-d H:i:s'),
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
            'Correo',
            'Teléfono',
            'Dirección',
            'Ciudad',
            'Departamento',
            'País',
            'Barrio',
            'Estado',
            'Fecha de Registro',
        ];
    }
}
