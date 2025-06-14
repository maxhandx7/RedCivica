<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRecursiveRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'cedula',
        'telefono',
        'barrio',
        'ciudad',
        'mesa',
        'password',
        'parent_id',
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

   

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'actor_id');
    }

    public function getDepthName()
    {
        return 'depth';
    }
}
