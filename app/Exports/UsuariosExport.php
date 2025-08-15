<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
       
        $users = User::select([
            'users.cedula',
            'users.name',
            'users.surname',
            'users.email',
            'users.telefono',
            'users.direccion',
            'users.ciudad',
            'users.departamento',
            'users.pais',
            'users.barrio',
            'users.estado',
            'users.created_at',
        ])
            ->get();

        return $users;
    }

    public function headings(): array
    {
        return [

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
