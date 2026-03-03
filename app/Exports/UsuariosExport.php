<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\LocationService;
use App\Services\parent_service;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromCollection, WithHeadings
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
        return DB::transaction(function () {

            $users = User::with(['parent', 'mesa'])
                ->select(
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
                    'parent_id',
                    'created_at'
                )
                ->get();

            $users = $this->locationService->resolveNames($users);

            return $users->map(function ($user) {

                $nombre_completo_padre = $user->parent
                    ? $user->parent->name . ' ' . $user->parent->surname
                    : 'N/A';

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
                    'mesa' => $user->mesa ? $user->mesa->mesa : 'N/A',
                    'pesto_votacion' => $user->mesa ? $user->mesa->puesto_votacion : 'N/A',
                    'zona' => $user->mesa ? $user->mesa->zona : 'N/A',
                    'direccion_votacion' => $user->mesa ? $user->mesa->direccion : 'N/A',
                    'nombre_padre' => $nombre_completo_padre,
                    'created_at' => Carbon::parse($user->created_at)
                        ->translatedFormat('d \d\e F \d\e Y'),
                ];
            });

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
            'Mesa',
            'Lugar de Votación',
            'zona',
            'Dirección de Votación',
            'Nombre del Referente',
            'Fecha de Registro',
        ];
    }
}