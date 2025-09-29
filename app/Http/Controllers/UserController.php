<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth');
       // $this->middleware('role:admin')->except(['form', 'store']);

        $this->middleware('auth')->except(['form', 'store']);
    $this->middleware('role:admin')->except(['form', 'store']);
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('cedula', 'like', "%{$search}%")
                    ->orWhere('mesa', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.user.index', compact('users'));
    }


    public function create()
    {

        $users = User::get();
        return view('admin.user.create', compact('users'));
    }


    public function store(Request $request, User $user)
    {
        try {
            $user->my_store_log($request);
            return redirect()->back()->with('success', 'Usuario credado con éxito');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Ocurrió un error al crear el usuario ' . $th->getMessage());
        }
    }

    public function show(User $user)
    {
        if ($user->ciudad) {
            $response = Http::get('https://secure.geonames.org/getJSON', [
                'geonameId' => $user->ciudad,
                'username' => 'Alan'
            ]);
        }
        if ($response->successful()) {
            $geoData = $response->json();
            $user->ciudad = $geoData['name'] ?? $user->ciudad;
        }
        return view('admin.user.show', compact('user'));
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'No puedes modificar este usuario');
        }
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        try {
            if ($user->id === 1) {
                return redirect()->back()->with('error', 'No puedes modificar este usuario');
            }

            $user->my_update($request, $user);
            return redirect()->route('users.index')->with('success', 'Usuario modificado');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el usuario ' . $th->getMessage());
        }
    }


    public function destroy(User $user)
    {
        try {

            if ($user->id === 1) {
                return redirect()->back()->with('error', 'No puedes eliminar a este usuario');
            }

            if ($user->id === auth()->id()) {
                return redirect()->back()->with('error', 'No puedes eliminar tu propio usuario');
            }

            if ($user->hasRole('admin')) {
                return redirect()->back()->with('error', 'No puedes eliminar un usuario con rol de administrador');
            }


            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuario eliminado');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el usuario');
        }
    }

    public function form(Request $request)
    {
        try {
            $user  = new User();

            // Ejecutar el almacenamiento
            $user->my_store($request);

            // Determinar el tipo de respuesta basado en la solicitud
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario creado con éxito',
                    'redirect' => url()->previous() // Opcional: redirección para AJAX
                ]);
            }

            return redirect()->back()->with('success', 'Usuario creado con éxito');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo especial para errores de validación
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $th) {
            // Manejo de otros errores
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al crear el usuario ',
                    'error' => $th->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Ocurrió un error al crear el usuario: ' . $th->getMessage())
                ->withInput();
        }
    }
}
