<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaña extends Model
{
    use HasFactory;


    
   protected $fillable = [
      'name',
      'description',
      'image',
   ];


   public function referencias()
    {
        return $this->hasMany(Referencia::class);
    }
}
