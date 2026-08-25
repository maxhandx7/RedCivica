<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class LocationService
{
    public function getDepName(Collection $users): Collection
    {
        $departmentIds = $users->pluck('departamento')
            ->filter()
            ->unique()
            ->values();

        $depMap = [];

        foreach ($departmentIds as $id) {
            $response = Http::get("https://api.afdeveloper.com/api/department/{$id}");

            if ($response->successful()) {
                $dep = collect($response->json())
                    ->firstWhere('geonameId', $id);

                if ($dep) {
                    $depMap[$id] = $dep['name'];
                }
            }
        }

        // Retornar la colección modificada
        return $users->map(function ($user) use ($depMap) {
            $user->departamento = $depMap[$user->departamento] ?? $user->departamento;
            return $user;
        });
    }


    public function getCityName(Collection $users): Collection
    {
        $cityIds = $users->pluck('ciudad')
            ->filter()
            ->unique()
            ->values();

        $cityMap = [];

        foreach ($cityIds as $id) {
            $response = Http::get("https://api.afdeveloper.com/api/city/{$id}");

            if ($response->successful()) {
                $city = collect($response->json())
                    ->firstWhere('geonameId', $id);

                if ($city) {
                    $cityMap[$id] = $city['name'];
                }
            }
        }

        // Retornar la colección modificada
        return $users->map(function ($user) use ($cityMap) {
            $user->ciudad = $cityMap[$user->ciudad] ?? $user->ciudad;
            return $user;
        });
    }


    public function resolveNames(Collection $users): Collection
    {
        // Resolver departamentos
        $depIds = $users->pluck('departamento')->filter()->unique()->values();
        $depMap = [];

        foreach ($depIds as $id) {
            $response = Http::get("https://api.afdeveloper.com/api/department/{$id}");
            if ($response->successful()) {
                $dep = collect($response->json())->firstWhere('geonameId', $id);
                if ($dep)
                    $depMap[$id] = $dep['name'];
            }
        }

        // Resolver ciudades
        $cityIds = $users->pluck('ciudad')->filter()->unique()->values();
        $cityMap = [];

        foreach ($cityIds as $id) {
            $response = Http::get("https://api.afdeveloper.com/api/city/{$id}");
            if ($response->successful()) {
                $city = collect($response->json())->firstWhere('geonameId', $id);
                if ($city)
                    $cityMap[$id] = $city['name'];
            }
        }

        // Aplicar ambos mapeos en un solo map()
        return $users->map(function ($user) use ($depMap, $cityMap) {
            $user->departamento = $depMap[$user->departamento] ?? $user->departamento;
            $user->ciudad = $cityMap[$user->ciudad] ?? $user->ciudad;
            return $user;
        });
    }


}