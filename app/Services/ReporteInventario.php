<?php
namespace App\Services;

use App\Models\Animal;
use App\Contracts\ReporteInterface;

class ReporteInventario implements ReporteInterface {
    public function generar(int $ranchoId): array {
        return Animal::where('rancho_id', $ranchoId)
            ->select('nombre', 'numero_arete', 'raza_id', 'sexo')
            ->get()->toArray();
    }
}