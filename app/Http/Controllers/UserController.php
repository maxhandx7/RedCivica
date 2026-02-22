<?php

namespace App\Http\Controllers;

use App\Models\Referencia;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;

class UserController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth')->except(['form', 'store', 'checkCedula']);
        $this->middleware('role:admin')->except(['form', 'store', 'checkCedula']);
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
                    ->orWhere('cedula', 'like', "%{$search}%");
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
        $responses = Http::pool(fn(Pool $pool) => [
            $pool->as('city')->get('https://api.afdeveloper.online/api/city/' . $user->ciudad),
            $pool->as('dept')->get('https://api.afdeveloper.online/api/department/' . $user->departamento),
        ]);

        if ($responses['city']?->successful() && isset($responses['city']->json()[0])) {
            $user->ciudad = $responses['city']->json()[0]['name'];
        }

        if ($responses['dept']?->successful() && isset($responses['dept']->json()[0])) {
            $user->departamento = $responses['dept']->json()[0]['name'];
        }

        return view('admin.user.show', compact('user'));
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'No puedes modificar este usuario');
        }
    
        $responses = Http::pool(fn(Pool $pool) => [
            $pool->as('city')->get('https://api.afdeveloper.online/api/city/' . $user->ciudad),
            $pool->as('dept')->get('https://api.afdeveloper.online/api/department/' . $user->departamento),
        ]);

        if ($responses['city']?->successful() && isset($responses['city']->json()[0])) {
            $user->ciudad = $responses['city']->json()[0]['name'];
        }

        if ($responses['dept']?->successful() && isset($responses['dept']->json()[0])) {
            $user->departamento = $responses['dept']->json()[0]['name'];
        }

        $referidos = auth()->user()->descendantsAndSelf()->depthFirst()->get();
        return view('admin.user.edit', compact('user', 'roles', 'referidos'));
    }

    public function update(Request $request, User $user)
    {
        try {
            if ($user->id === 1) {
                return redirect()->back()->with('error', 'No puedes modificar este usuario');
            }

            $user->my_update($request, $user);
            return redirect()->back()->with('success', 'Usuario modificado');
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
            $user = new User();

            $user->my_store($request);

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

    public function checkCedula(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string|max:20',
        ]);

        $exists = User::where('cedula', $request->cedula)->exists();

        if ($exists) {
            User::where('cedula', $request->cedula)
                ->update([
                    'referencia_id' => $request->ref_id
                ]);
        }

        $referencia = Referencia::where('id', $request->ref_id)
            ->first();

        $campaña = $referencia ? $referencia->campaña->name : null;

        return response()->json([
            'exists' => $exists,
            'ref' => $referencia,
            'campaña' => $campaña
        ]);
    }
}
