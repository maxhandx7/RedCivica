<?php

namespace App\Imports;

use App\Models\Mesa;
use App\Models\Referencia;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;

class UsuariosImport implements ToModel, WithHeadingRow, WithStartRow
{
    protected $headingRow;
    protected $startRow;
    protected $cedulaDueno;
    protected $dueno;

    public function __construct($headingRow, $startRow, $cedulaDueno)
    {
        $this->headingRow = $headingRow;
        $this->startRow = $startRow;
        $this->cedulaDueno = $cedulaDueno;

        // Buscar al dueño una sola vez, no en cada fila
        $this->dueno = User::where('cedula', $cedulaDueno)->first();
    }

    public function startRow(): int
    {
        return $this->startRow;
    }

    public function headingRow(): int
    {
        return $this->headingRow;
    }

    public function model(array $row)
    {

        $email = $row['email'] ?? null;

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = null;
        }

        if (User::where('cedula', $row['cedula'])->exists()) {
            return null;
        }




        return DB::transaction(function () use ($row) {
            $ultimaId = Referencia::max('id');

            $mesa = Mesa::firstOrCreate(
                [
                    'municipio' => $row['municipio'] ?? 'No especificado',
                    'puesto_votacion' => $row['lugar_de_votacion'] ?? 'No especificado',
                    'mesa' => $row['mesa'] ?? 'No especificado',
                    'zona' => $row['zona'] ?? 'No especificado',
                ],
                [
                    'departamento' => $row['departamento'] ?? 'No especificado',
                    'direccion' => $row['dir_votacion'] ?? 'No especificado',
                ]
            );

            $user = User::create([
                'mesa_id' => $mesa->id ?? null,
                'name' => $row['nombre'],
                'surname' => $row['apellidos'] ?? "no especificado",
                'cedula' => $row['cedula'] ?? rand(10000000, 99999999),
                'tipo_documento' => 'cc',
                'telefono' => $row['celular'] ?? "no especificado",
                'email' => $row['email'] ?? "no especificado",
                'comuna' => $row['comuna'] ?? "no especificado",
                'barrio' => $row['barrio'] ?? "no especificado",
                'password' => bcrypt('12345678'),
                'pais' => '3686110',
                'parent_id' => $this->dueno?->id ?? 1,
                'referencia_id' => $ultimaId ?? null,
            ]);

            return $user;
        });
    }
}