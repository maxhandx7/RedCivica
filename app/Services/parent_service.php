<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class parent_service
{
  

    public function getParentName()
    {
        $referidos = auth()->user()->descendantsAndSelf()->depthFirst()->get();

        $networkData = $referidos->map(function ($u) use ($referidos) {
            $nivel = 1;
            $parent = $u;

            // dd($parent->parent_id && $parent->parent_id !== auth()->id());

            while ($parent && $parent->parent_id && $parent->parent_id !== auth()->id()) {
                $nivel++;
                $parent = $referidos->firstWhere('id', $parent->parent_id);

                // Si no encontramos al padre, salimos del bucle
                if (!$parent) {
                    break;
                }
            }

            return [
                'id' => (string) $u->id, // 👈 FORZAR STRING
                'name' => $u->name,
                'surname' => $u->surname,
            ];
        });


        return $networkData;
    }

}