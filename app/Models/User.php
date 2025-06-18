<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRecursiveRelationships, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'cedula',
        'telefono',
        'barrio',
        'direccion',
        'ciudad',
        'mesa',
        'password',
        'parent_id',
        'google_id',
        'referencia_id',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    // Relación padre (quién me refirió)
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // Hijos directos (a quién he referido)
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // Referencias generadas
    public function referencias()
    {
        return $this->hasMany(Referencia::class);
    }

    public function referencia()
    {
        return $this->belongsTo(Referencia::class);
    }



    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'actor_id');
    }

    public function getDepthName()
    {
        return 'depth';
    }



    public function my_store($request)
    {
        // Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cedula' => 'required|digits_between:6,10|unique:users,cedula',
            'telefono' => 'nullable|digits_between:10,15',
            'email' => 'required|email|unique:users,email',
            'direccion' => 'nullable|string|max:255',
            'barrio' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'mesa' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:users,id',
            'fuente' => 'nullable|string|max:50',
            'medio' => 'nullable|string|max:50',
            'terms' => 'accepted',
            'referencia_id' => 'nullable|exists:referencias,id',
        ]);


        self::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'barrio' => $request->barrio,
            'ciudad' => $request->ciudad,
            'mesa' => $request->mesa,
            'parent_id' => $request->parent_id,
            'fuente' => $request->fuente,
            'medio' => $request->medio,
            'password' => Hash::make('password123'), 
            'referencia_id' => $request->referencia_id,
        ]);

    }


    public function my_update($request, $user)
{
    // Validación para actualización
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'cedula' => 'required|digits_between:6,10|unique:users,cedula,'.$user->id,
        'telefono' => 'nullable|digits_between:10,15',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'direccion' => 'nullable|string|max:255',
        'barrio' => 'nullable|string|max:255',
        'ciudad' => 'nullable|string|max:255',
        'mesa' => 'nullable|string|max:50',
        'parent_id' => 'nullable|exists:users,id',
        'fuente' => 'nullable|string|max:50',
        'medio' => 'nullable|string|max:50',
        'password' => 'nullable|string|min:8|confirmed',
        'active' => 'sometimes|boolean',
        'referencia_id' => 'nullable|exists:referencias,id',
    ]);

    // Preparar datos para actualización
    $updateData = [
        'name' => $validatedData['name'],
        'surname' => $validatedData['surname'],
        'cedula' => $validatedData['cedula'],
        'telefono' => $validatedData['telefono'],
        'email' => $validatedData['email'],
        'direccion' => $validatedData['direccion'],
        'barrio' => $validatedData['barrio'],
        'ciudad' => $validatedData['ciudad'],
        'mesa' => $validatedData['mesa'],
        'parent_id' => $validatedData['parent_id'] ?? $user->parent_id,
        'fuente' => $validatedData['fuente'] ?? $user->fuente,
        'medio' => $validatedData['medio'] ?? $user->medio,
        'referencia_id' => $validatedData['referencia_id'] ?? $user->referencia_id,
    ];

    // Actualizar contraseña solo si se proporcionó
    if (!empty($validatedData['password'])) {
        $updateData['password'] = Hash::make($validatedData['password']);
    }

    // Realizar la actualización
    self::update($updateData);

    return $user;
}
}
