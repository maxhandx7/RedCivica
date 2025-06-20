<?php

namespace App\Http\Controllers;

use App\Especialidad;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
 

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
            return redirect()->back()->with('error', 'Ocurrió un error al crear el usuario '. $th->getMessage());
        }
    }

    public function show(User $user)
    {

        return view('admin.user.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $user->my_update($request, $user);
            return redirect()->route('users.index')->with('success', 'Usuario modificado');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el usuario ' . $th->getMessage());
        }
    }


    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuario eliminado');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el usuario');
        }
    }

    public function form(Request $request, User $user)
    {
        try {
            if ($request->has('terms')) {
                $user->my_store($request);
            } else {
                return redirect()->back()->with('error', 'Debe aceptar los términos y condiciones para continuar');
            }
            return redirect()->back()->with('success', 'Usuario credado con éxito');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Ocurrió un error al crear el usuario '. $th->getMessage());
        }
    }
}
