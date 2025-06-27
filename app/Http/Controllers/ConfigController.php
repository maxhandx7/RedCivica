<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfigController extends Controller
{
    public function edit($id)
    {
        $validate = Auth::user()->id;
        if ($validate != $id) {
            return back()->with('error', 'No esta permitido hacer eso');
        }
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
        $referidos = auth()->user()->descendantsAndSelf()->depthFirst()->get();
        $referido = $referidos->first();
        $referidos->each(function ($referido) {
            $referido->formatted_date = $referido->created_at->isoFormat('D [de] MMMM [de] YYYY');
            $referido->nivel = $referido->depth;
        });


        return view('admin.config.edit', [
            'user' => $user,
            'referidos' => $referido
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('configs.edit', Auth::user()->id)->with('success', '¡Contraseña cambiada exitosamente!');
        } else {
            return back()->withErrors(['current_password' => 'La contraseña actual no coincide con nuestros registros.']);
        }
    }


    public function showChangePasswordForm()
    {
        return view('admin.config.change-password');
    }

    public function update(Request $request, User $user)
    {
        try {
            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->back()->with('success', 'Usuario modificado');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el usuario');
        }
    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/image');
            $image->move($destinationPath, $name);

            // Opcional: eliminar la imagen anterior
            if ($user->image) {
                $oldImagePath = public_path('/image/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Actualizar perfil con el nuevo nombre de la imagen
            $user->image = $name;
            $user->save();

            return response()->json(['success' => true, 'image_url' => asset('image/' . $name)]);
        }

        return response()->json(['success' => false]);
    }
}
