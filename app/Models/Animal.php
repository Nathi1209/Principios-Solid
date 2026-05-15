<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    // Datos comunes para cualquier tipo de animal 
    protected $fillable = [
        'numero_arete', 
        'nombre', 
        'raza_id', 
        'rancho_id'
    ];

    public function obtenerIdentificacion(): string
    {
        return $this->nombre . ' - ' . $this->numero_arete;
    }
}