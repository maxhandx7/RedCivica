<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioRedResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => (string) $this->id,
            'name'            => $this->name,
            'surname'         => $this->surname,
            'email'           => $this->email,
            'tipo_documento'  => $this->tipo_documento,
            'cedula'          => $this->cedula,
            'fecha_nacimiento' => $this->formatearFecha($this->fecha_nacimiento),
            'fecha_expedicion' => $this->formatearFecha($this->fecha_expedicion),
            'direccion'       => $this->direccion,
            'barrio'          => $this->barrio,
            'ciudad'          => $this->ciudad_nombre,
            'departamento'    => $this->departamento_nombre,
            'mesa'            => $this->mesa,
            'telefono'        => $this->telefono,
            'created_at'      => $this->created_at->isoFormat('D [de] MMMM [de] YYYY'),
            'parent_id'       => (string) $this->parent_id,
            'nombre_padre'    => $this->nombre_padre_calc,
            'nivel'           => $this->nivel_calculado ?? 1,
            'no'              => $this->children->count(),
        ];
    }

    private function formatearFecha(?string $fecha): ?string
    {
        return $fecha
            ? Carbon::parse($fecha)->isoFormat('D [de] MMMM [de] YYYY')
            : null;
    }
}