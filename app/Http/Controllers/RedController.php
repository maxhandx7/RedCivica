<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsuarioRedResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Need;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class RedController extends Controller
{


    public function index()
    {
        $user   = auth()->user();
        $authId = $user->id;

        $arbol = $user
            ->descendantsAndSelf()
            ->depthFirst()
            ->with(['children:id,parent_id', 'parent:id,name,surname'])
            ->get();

        $niveles     = $this->calcularNiveles($arbol, $authId);
        $referidosMap = $arbol->keyBy('id');

        $ciudades     = $this->cachearLookup($arbol, 'ciudad',      fn($v) => $this->getCity($v));
        $departamentos = $this->cachearLookup($arbol, 'departamento', fn($v) => $this->getDep($v));

        $networkData = UsuarioRedResource::collection(
            $arbol->each(function ($u) use ($niveles, $referidosMap, $ciudades, $departamentos) {
                $u->nivel_calculado   = $niveles[$u->id]   ?? 1;
                $u->nombre_padre_calc = $referidosMap[$u->parent_id]->name ?? null;
                $u->ciudad_nombre     = $ciudades[$u->ciudad]             ?? null;
                $u->departamento_nombre = $departamentos[$u->departamento] ?? null;
            })
        );

        $topReferidores = $arbol
            ->where('id', '!=', $authId)
            ->sortByDesc(fn($u) => $u->children->count())
            ->take(3)
            ->values()
            ->each(fn($u) => $u->children_count = $u->children->count());

        $needs = Need::where('registrado_por', $authId)
            ->with('registradoPor:id,name')
            ->get();

        return view('admin.red.index', [
            'referidos'      => $arbol->where('id', '!=', $authId)->values(),
            'networkData'    => $networkData,
            'topReferidores' => $topReferidores,
            'needs'          => $needs,
        ]);
    }

    // ─── Helpers privados ───────────────────────────────────────────────────────

    /**
     * Calcula el nivel de cada nodo en el árbol (nivel 1 = hijo directo del auth).
     * depthFirst garantiza que el padre siempre se procesa antes que el hijo.
     */
    private function calcularNiveles(Collection $arbol, int $authId): array
    {
        $niveles = [];

        foreach ($arbol as $u) {
            $niveles[$u->id] = match (true) {
                $u->id === $authId        => 0,          // raíz
                $u->parent_id === $authId => 1,          // nivel directo
                isset($niveles[$u->parent_id])
                    => $niveles[$u->parent_id] + 1,      // derivado
                default => 1,
            };
        }

        return $niveles;
    }

    /**
     * Construye un array [valor_crudo => valor_legible] sin repetir llamadas costosas.
     */
    private function cachearLookup(Collection $arbol, string $campo, callable $resolver): array
    {
        return $arbol
            ->pluck($campo)
            ->unique()
            ->filter()
            ->mapWithKeys(fn($valor) => [$valor => $resolver($valor)])
            ->all();
    }
    /* public function index()
    {
        $authId = auth()->id();

        // Eager load children y parent de una vez
        $referidos = auth()->user()
            ->descendantsAndSelf()
            ->depthFirst()
            ->with(['children:id,parent_id', 'parent:id,name'])
            ->get();

        // Preconstruir mapa id => usuario para O(1) en vez de firstWhere O(n)
        $referidosMap = $referidos->keyBy('id');

        // Precalcular niveles en un solo paso usando el orden depthFirst
        // (ya viene ordenado de arriba a abajo, podemos aprovechar eso)
        $niveles = [];
        foreach ($referidos as $u) {
            if ($u->parent_id === null || $u->parent_id == $authId) {
                $niveles[$u->id] = 1;
            } else {
                $niveles[$u->id] = ($niveles[$u->parent_id] ?? 1);
            }
        }

        // Cachear ciudades y departamentos para no llamar getCity/getDep N veces
        $ciudadCache = [];
        $depCache = [];

        $networkData = $referidos->map(function ($u) use ($referidosMap, $niveles, $authId, &$ciudadCache, &$depCache) {
            $ciudadCache[$u->ciudad] ??= $this->getCity($u->ciudad);
            $depCache[$u->departamento] ??= $this->getDep($u->departamento);

            return [
                'id' => (string) $u->id,
                'name' => $u->name,
                'surname' => $u->surname,
                'email' => $u->email,
                'tipo_documento' => $u->tipo_documento,
                'cedula' => $u->cedula,
                'fecha_nacimiento' => $u->fecha_nacimiento
                    ? Carbon::parse($u->fecha_nacimiento)->isoFormat('D [de] MMMM [de] YYYY')
                    : null,
                'fecha_expedicion' => $u->fecha_expedicion
                    ? Carbon::parse($u->fecha_expedicion)->isoFormat('D [de] MMMM [de] YYYY')
                    : null,
                'direccion' => $u->direccion,
                'barrio' => $u->barrio,
                'ciudad' => $ciudadCache[$u->ciudad],
                'departamento' => $depCache[$u->departamento],
                'mesa' => $u->mesa,
                'telefono' => $u->telefono,
                'created_at' => $u->created_at->isoFormat('D [de] MMMM [de] YYYY'),
                'parent_id' => (string) $u->parent_id,
                'nombre_padre' => $u->parent_id
                    ? ($referidosMap[$u->parent_id]->name ?? null)
                    : null,
                'nivel' => $niveles[$u->id] ?? 1,
                'no' => $u->children->count(), // ya eager loaded, sin query
            ];
        });

        // formatted_date: aprovechar el valor ya calculado en networkData
        // si la vista solo necesita esto, puedes quitarlo o mapearlo desde networkData
        foreach ($referidos as $referido) {
            $referido->formatted_date = $referido->created_at->isoFormat('D [de] MMMM [de] YYYY');
        }

        // Top 3: ya tenemos children eager loaded, calcular en memoria sin query extra
        $topReferidores = $referidos
            ->where('id', '!=', $authId)
            ->sortByDesc(fn($u) => $u->children->count())
            ->take(3)
            ->values();

        $needs = Need::where('registrado_por', auth()->id())
            ->with('registradoPor:id,name')
            ->get();

        return view('admin.red.index', [
            'referidos' => $referidos,
            'networkData' => $networkData,
            'topReferidores' => $topReferidores,
            'needs' => $needs,
        ]);
    } */

    public function getCity($ciudad)
    {
        $response = Http::get('https://api.afdeveloper.com/api/city/' . $ciudad);

        if ($response->successful()) {
            return collect($response->json())
                ->first()['name'] ?? $ciudad;
        }
        return $ciudad;
    }


    public function getDep($dep)
    {
        $response = Http::get('https://api.afdeveloper.com/api/department/' . $dep);

        if ($response->successful()) {
            return collect($response->json())
                ->first()['name'] ?? $dep;
        }
        return $dep;
    }

}
