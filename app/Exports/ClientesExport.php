<?php

namespace App\Exports;

use App\Models\User;
use App\Services\LocationService;
use App\Services\parent_service;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, WithHeadings
{
    private $locationService;
    private $parentService;

    public function __construct(LocationService $locationService, parent_service $parentService)
    {
        $this->locationService = $locationService;
        $this->parentService = $parentService;
    }

    public function collection()
    {
        $clients = auth()->user()->descendantsAndSelf()->depthFirst()->get();


        $users = $this->locationService->resolveNames($clients);



        return $users->map(function ($user) {
            $nombre_completo_padre = $user->parent ? $user->parent->name . ' ' . $user->parent->surname : 'N/A';
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
                'ciudad' => $user->ciudad, // ya viene con el nombre resuelto
                'comuna' => $user->comuna,
                'barrio' => $user->barrio,
                'direccion' => $user->direccion,
                'estado' => $user->estado,
                'nombre_padre' => $nombre_completo_padre, // Aquí se obtiene el nombre del referente
                'created_at' => Carbon::parse($user->created_at)
                    ->translatedFormat('d \d\e F \d\e Y'),
            ];
        });
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
            'Nombre del Referente',
            'Fecha de Registro',
        ];
    }
}