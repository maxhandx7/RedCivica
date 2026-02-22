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


        // Saltar duplicados
        $email = $row['email'];

        if (User::where('email', $email)->exists()) {

            $baseEmail = explode('@', $email)[0];
            $domain = explode('@', $email)[1];

            $counter = 1;

            while (User::where('email', $email)->exists()) {
                $email = $baseEmail . $counter . '@' . $domain;
                $counter++;
            }
        }

        if (User::where('cedula', $row['cedula'])->exists()) {
            return null;
        }



        return DB::transaction(function () use ($row) {
            $ultimaId = Referencia::max('id');

            $mesa = Mesa::create([
                'departamento' => $row['departamento'] ?? 'No especificado',
                'municipio' => $row['municipio'] ?? 'No especificado',
                'puesto_votacion' => $row['lugar_de_votacion'] ?? 'No especificado',
                'mesa' => $row['mesa'] ?? 'No especificado',
                'zona' => $row['zona'] ?? 'No especificado',
                'direccion' => $row['direccion_de_votacion'] ?? 'No especificado',
            ]);

            $user = User::create([
                'mesa_id' => $mesa->id,
                'name' => $row['nombre'],
                'surname' => $row['apellidos'],
                'cedula' => $row['cedula'],
                'telefono' => $row['celular'],
                'email' => $row['email'],
                'comuna' => $row['comuna'] ?? null,
                'barrio' => $row['barrio'] ?? null,
                'tipo_documento' => 'cc',
                'password' => bcrypt('12345678'),
                'pais' => '3686110',
                'parent_id' => $this->dueno?->id ?? 1,
                'referncia_id' => $ultimaId->id ?? null,
            ]);

            return $user;
        });
    }
}