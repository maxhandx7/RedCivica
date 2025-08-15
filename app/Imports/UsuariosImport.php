<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsuariosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'     => $row[0],
            'surname'    => $row[1],
            'email'    => $row[2],
            'cedula' => $row[3],
            'telefono' => $row[4],
            'direccion' => $row[5],
            'ciudad' => $row[6],
            'departamento' => $row[7],
            'pais' => $row[8],
            'barrio' => $row[9],
            'created_at' => now(),
            'password' => bcrypt( 'password'), // Default password, change as needed
        ]);
    }
}
