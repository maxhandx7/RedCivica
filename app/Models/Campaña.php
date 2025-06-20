<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Services\ActividadService;
use App\Constants\ActividadPlantillas;

class Campaña extends Model
{
    use HasFactory;



    protected $fillable = [
        'name',
        'slug',
        'estado',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'description',
        'image',
    ];


    public function referencias()
    {
        return $this->hasMany(Referencia::class);
    }


    public function my_store($request)
    {
        $image = $this->imageCharge($request);

        $campaña = self::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'estado' => $request->estado ?? 'activo',
            'tipo' => $request->tipo ?? 'publica',
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'description' => $request->description,
            'image' => $image,
        ]);

        if ($campaña) {
            $this->notified();
        } else {
            throw new \Exception('Error al crear la campaña');
        }

        return $campaña;
    }

    public function my_update($request)
    {
        $image = $this->imageCharge($request);

        $this->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '_'),
            'estado' => $request->estado ?? 'activo',
            'tipo' => $request->tipo ?? 'publica',
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'description' => $request->description,
            'image' => $image ?? $this->image,
        ]);
    }


    public function imageCharge($request)
    {
        $image_name = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("/image"), $image_name);
            if ($this->image) {
                $this->deleteOldImage();
            }
        }
        return $image_name;
    }

    public function deleteOldImage()
    {
        $old_image_path = public_path("/image/") . $this->image;

        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
    }

    public function notified()
    {
        ActividadService::registrar(
            ActividadPlantillas::NUEVA_CAMPAÑA,
            $this->id   
        );
    }
}
