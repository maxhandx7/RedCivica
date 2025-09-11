<?php

namespace App\Http\Controllers;

use App\Models\Campaña;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $campañas = Campaña::get();

        $referidosTotales = $user->descendants()->count();
        $total = $user->descendants()->count();
        $conReferidos = $user->descendants()->has('children')->count();
        $recientes = $user->descendants()
            ->where('created_at', '>=', now()->subDays(15))
            ->count();

        $probabilidadVoto = $total > 0
            ? round((($conReferidos + $recientes) / (2 * $total)) * 100)
            : 0;
        $partidariosActivos = User::has('parent')->count();

        //noticias

        $noticias = [];
        /* if ($user->hasRole('cliente')) {
            $client = new Client();
            $res = $client->get('https://api.mediastack.com/v1/news', [
                'query' => [
                    'access_key' => env('MEDIASTACK_KEY'),
                    'countries' => 'co',
                    'categories' => 'general',
                    'languages' => 'es',
                    'keywords' => 'politica',
                    'limit' => 6,
                ],
            ]);



            $body = json_decode($res->getBody(), true);
            $whitelist = [
                'elespectador.com',
                'lasillavacia.com',
                'elcolombiano.com',
                'noticiasunolared.com',
                'razonpublica.com',
                'semana.com',
                'enter.co'

            ];


            foreach ($body['data'] as $article) {
                $host = parse_url($article['url'], PHP_URL_HOST);
                $normalizedHost = preg_replace('/^(www\.|m\.)/', '', $host);

               foreach ($whitelist as $allowedDomain) {
                    if (str_ends_with($normalizedHost, $allowedDomain)) {
                        $noticias[] = $article;
                     break;
                    }
                }
            }

        } */

        // IDs de todos los descendientes (incluido el mismo user si quieres)
        $descendantIds = $user->descendants()->pluck('id');

        $dataDate = User::whereIn('id', $descendantIds)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $dataDep = User::whereIn('id', $descendantIds)
            ->select('departamento', DB::raw('COUNT(*) as total'))
            ->groupBy('departamento')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $dataCity = User::whereIn('id', $descendantIds)
            ->select('ciudad', DB::raw('COUNT(*) as total'))
            ->groupBy('ciudad')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $labelsDate = $dataDate->pluck('mes');
        $totalsDate = $dataDate->pluck('total');
        $labelsDep = $this->getDepName($dataDep);
        $totalsDep = $dataDep->pluck('total');
        $totalsCity = $dataCity->pluck('total');
        $labelsCity = $this->getCityName($dataCity);


        return view('home', compact(
            'referidosTotales',
            'probabilidadVoto',
            'campañas',
            'labelsDate',
            'totalsDate',
            'labelsDep',
            'totalsDep',
            'labelsCity',
            'totalsCity',
            'partidariosActivos',
            'noticias'
        ));
    }

    public function getDepName($data)
    {
        return $data->pluck('departamento')->map(function ($code) {
            $resp = Http::get('https://secure.geonames.org/getJSON', [
                'geonameId' => $code,
                'username' => 'Alan', // tu usuario de GeoNames
            ]);

            return $resp->json('name') ?? $code; // fallback por si no hay name
        });
    }

    public function getCityName($data)
    {
        return $data->pluck('ciudad')->map(function ($code) {
            $resp = Http::get('https://secure.geonames.org/getJSON', [
                'geonameId' => $code,
                'username' => 'Alan', 
            ]);
            return $resp->json('name') ?? $code; // fallback por si no hay name
        });
    }


}
