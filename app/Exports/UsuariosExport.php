<?php

namespace App\Exports;

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
       
       $controller = app(DashboardController::class);

        $users = User::select(
                'id',
                'cedula',
                'name',
                'surname',
                'fecha_nacimiento',
                'email',
                'telefono',
                'direccion',
                'comuna',
                'barrio',
                'ciudad',
                'departamento',
                'estado',
                'created_at'
            )
            ->get();

        $ciudad = $controller->getCityName($users);
        $ciudad = $ciudad->toArray();
        foreach ($users as $index => $user) {
            $user->ciudad = $ciudad[$index];
        }

        $departamento = $controller->getDepName($users);
        $departamento = $departamento->toArray();
        foreach ($users as $index => $user) {
            $user->departamento = $departamento[$index];
        }

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'cedula' => $user->cedula,
                'name' => $user->name,
                'surname' => $user->surname,
                'fecha_nacimiento' => $user->fecha_nacimiento,
                'edad' => Carbon::parse($user->fecha_nacimiento)->age,
                'email' => $user->email,
                'telefono' => $user->telefono,
                'pais' => 'Colombia',
                'departamento' => $user->departamento,
                'ciudad' => $user->ciudad,
                'comuna' => $user->comuna,
                'barrio' => $user->barrio,
                'direccion' => $user->direccion,
                'estado' => $user->estado,
                'created_at' => Carbon::parse($user->created_at)->translatedFormat('d \d\e F \d\e Y'),
            ];
        });
        return $data;
        
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
