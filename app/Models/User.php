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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\ActividadService;
use App\Constants\ActividadPlantillas;
use App\Mail\BienvenidaUsuarioMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


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
        'tipo_documento',
        'cedula',
        'fecha_nacimiento',
        'fecha_expedicion',
        'telefono',
        'barrio',
        'direccion',
        'ciudad',
        'comuna',
        'estado',
        'image',
        'departamento',
        'pais',
        'mesa',
        'password',
        'parent_id',
        'google_id',
        'referencia_id',
        'business_id',
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
        'last_login_at' => 'datetime',
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

    // El "hijo" que crea necesidades
    // Necesidades reportadas por este usuario
    public function necesidadesReportadas()
    {
        return $this->hasMany(Need::class, 'registrado_por');
    }



    public function business()
    {
        return $this->belongsTo(Business::class);
    }


    public function my_store($request)
    {

        $request->merge([
            'fecha_nacimiento' => Carbon::createFromFormat('d/m/Y', $request->fecha_nacimiento)->format('Y-m-d'),
            'fecha_expedicion' => Carbon::createFromFormat('d/m/Y', $request->fecha_expedicion)->format('Y-m-d'),
        ]);



        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:50',
            'cedula' => 'required|digits_between:6,10|unique:users,cedula',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d')
            ],
            'fecha_expedicion' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $fechaNacimiento = Carbon::parse($request->fecha_nacimiento);
                    $fechaExpedicion = Carbon::parse($value);

                    $edadEnExpedicion = $fechaNacimiento->diffInYears($fechaExpedicion);

                    if ($edadEnExpedicion < 18) {
                        $fail('Debía ser mayor de edad al momento de expedir la cédula.');
                    }

                    if ($fechaExpedicion->lt($fechaNacimiento)) {
                        $fail('La fecha de expedición no puede ser anterior a la fecha de nacimiento.');
                    }
                }
            ],
            'email' => 'nullable|email|unique:users,email',
            'direccion' => 'nullable|string|max:255',
            'barrio' => 'nullable|string|max:255',
            'ciudad' => 'nullable',
            'departamento' => 'nullable',
            'comuna' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:50',
            'pais' => 'nullable',
            'estado' => 'nullable|string|in:activo,inactivo',
            'mesa' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:users,id',
            'fuente' => 'nullable|string|max:50',
            'medio' => 'nullable|string|max:50',
            'referencia_id' => 'nullable|exists:referencias,id',
        ]);

        $password = Str::random(12);

        $user = self::where('cedula', $request->cedula)->first();
        
        if ($user) {
            // Si el usuario ya existe, actualizar sus datos
            $user->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'fecha_expedicion' => $request->fecha_expedicion,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'barrio' => $request->barrio,
                'departamento' => $request->departamento,
                'ciudad' => $request->ciudad,
                'comuna' => $request->comuna,
                'pais' => $request->pais ?? 'Colombia',
                'estado' => $request->estado ?? 'activo',
                'mesa' => $request->mesa,
                'parent_id' => $request->parent_id,
                'fuente' => $request->fuente,
                'medio' => $request->medio,
                'referencia_id' => $request->referencia_id,
            ]);
        } else {
            // Si no existe, crear nuevo usuario
            $user = self::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'tipo_documento' => $request->tipo_documento,
                'cedula' => $request->cedula,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'fecha_expedicion' => $request->fecha_expedicion,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'direccion' => $request->direccion,
                'barrio' => $request->barrio,
                'departamento' => $request->departamento,
                'ciudad' => $request->ciudad,
                'comuna' => $request->comuna,
                'pais' => $request->pais ?? 'Colombia',
                'estado' => $request->estado ?? 'activo',
                'mesa' => $request->mesa,
                'parent_id' => $request->parent_id,
                'fuente' => $request->fuente,
                'medio' => $request->medio,
                'password' => Hash::make($password),
                'referencia_id' => $request->referencia_id,
            ]);
        }

        if ($user) {
            // Asignar rol solo si es nuevo usuario o si no tiene roles
            if (!$user->hasRole("cliente")) {
                $user->assignRole("cliente");
            }

            // Enviar email solo para usuarios nuevos
            if (/* !$user->wasRecentlyCreated &&  */ $user->email) {
                Mail::to($user->email)->send(new BienvenidaUsuarioMail($user, $password));
            }

            $this->notified_form($user->id, $request->parent_id);

            return $user;
        } else {
            throw new \Exception('Error al crear o actualizar el usuario');
        }
    }


    public function my_update($request, $user)
    {
        // Validación para actualización
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cedula' => 'required|digits_between:6,10|unique:users,cedula,' . $user->id,
            'telefono' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'direccion' => 'nullable|string|max:255',
            'barrio' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'comuna' => 'nullable|string|max:50',
            'pais' => 'nullable|string|max:50',
            'mesa' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:users,id',
            'fuente' => 'nullable|string|max:50',
            'medio' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8|confirmed',
            'estado' => 'nullable',
            'referencia_id' => 'nullable|exists:referencias,id',
        ]);

        // Preparar datos para actualización
        $updateData = [
            'name' => $validatedData['name'] ?? null,
            'surname' => $validatedData['surname'] ?? null,
            'cedula' => $validatedData['cedula'] ?? null,
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'] ?? null,
            'fecha_expedicion' => $validatedData['fecha_expedicion'] ?? null,
            'telefono' => $validatedData['telefono'] ?? null,
            'email' => $validatedData['email'] ?? null,
            'direccion' => $validatedData['direccion'] ?? null,
            'barrio' => $validatedData['barrio'] ?? null,
            'ciudad' => $validatedData['ciudad'] ?? null,
            'departamento' => $validatedData['departamento'] ?? null,
            'comuna' => $validatedData['comuna'] ?? null,
            'pais' => $validatedData['pais'] ?? 'Colombia',
            'mesa' => $validatedData['mesa'] ?? null,
            'estado' => $user->estado ?? null,
            'parent_id' => $validatedData['parent_id'] ?? $user->parent_id,
            'fuente' => $validatedData['fuente'] ?? $user->fuente,
            'medio' => $validatedData['medio'] ?? $user->medio,
            'referencia_id' => $validatedData['referencia_id'] ?? $user->referencia_id,
        ];

        // Actualizar contraseña solo si se proporcionó
        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }
        $this->syncRoles($request->role);
        // Realizar la actualización
        self::update($updateData);

        return $user;
    }

    public function notified_form($id, $parent_id = null)
    {
        if ($id || $parent_id) {
            ActividadService::registrar(
                ActividadPlantillas::NUEVO_REFERIDO,
                $id,
                $parent_id

            );
        } else {
            throw new \Exception('ID o Parent ID no proporcionados');
        }

    }


    public function notified_user($id, $parent_id = null)
    {

        if ($id || $parent_id) {
            ActividadService::registrar(
                ActividadPlantillas::NUEVO_USUARIO,
                $id,
                $parent_id
            );
        } else {
            throw new \Exception('ID o Parent ID no proporcionados');
        }

    }

    public function my_store_log($request)
    {
        if ($request->estado === 'on') {
            $request->estado = 'activo';
        } else {
            $request->estado = 'inactivo';
        }
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
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!isset($request->role)) {
            $request->role = 'cliente';
        } else {
            $validator = Validator::make($request->all(), [
                'role' => 'required|exists:roles,name',
            ]);

            if ($validator->fails()) {
                throw new \Exception('El rol seleccionado no es válido.');
            }
        }

        if ($request->password === $request->password_confirmation) {
            $request->password = Hash::make($request->password);
        } else {
            throw new \Exception('Las contraseñas no coinciden.');
        }

        $user = self::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'barrio' => $request->barrio,
            'ciudad' => $request->ciudad,
            'estado' => $request->estado ?? 'activo',
            'mesa' => $request->mesa,
            'parent_id' => Auth::id(),
            'fuente' => $request->fuente ?? 'web',
            'medio' => $request->medio ?? 'directo',
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        if ($user) {
            $this->notified_user($user->id, Auth::id());
        } else {
            throw new \Exception('Error al crear la actividad');
        }

    }

    public function estado()
    {
        switch ($this->estado) {
            case 'activo':
                return [
                    'estado' => true,
                    'text' => 'Activo'
                ];
            case 'inactivo':
                return [
                    'estado' => false,
                    'text' => 'Inactivo'
                ];

            default:
                return [
                    'estado' => 'danger',
                    'text' => 'Error'
                ];
        }
    }

}


