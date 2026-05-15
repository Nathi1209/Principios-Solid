<?php
namespace App\Services;

use App\Models\Animal;
use App\Contracts\ReporteInterface;

class ReporteCondicionCorporal implements ReporteInterface {
    public function generar(int $ranchoId): array {
        $animales = Animal::where('rancho_id', $ranchoId)->get();

        return $animales->map(fn($a) => [
            'animal' => $a->nombre,
            'icc'    => $a->calcularIndiceCondicionCorporal(),
        ])->toArray();
    }
}