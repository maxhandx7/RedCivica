<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();
            $ultimoId = User::latest('id')->first()->id;
            
            if (!$user) {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'cedula' => 'temp-'.$ultimoId,
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)), // Contraseña aleatoria
                    'email_verified_at' => now(), // Marcar como verificado
                ]);
            } else {
                // Actualizar google_id si es necesario
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            }

            Auth::login($user);

            return redirect()->intended('/home');

        } catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Error al iniciar sesión con Google'.$e->getMessage());
        }
    }
}