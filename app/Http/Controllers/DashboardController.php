<?php

namespace App\Http\Controllers;

use App\Models\Campaña;
use Illuminate\Http\Request;
use App\Models\User;
use GuzzleHttp\Client;


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
        return view('home', compact(
            'referidosTotales',
            'probabilidadVoto',
            'campañas',
            'partidariosActivos',
            'noticias'
        ));
    }
}
