<?php
namespace App\Services;

use App\Models\Animal;
use App\Contracts\ReporteInterface;

class ReporteProgresoPeso implements ReporteInterface {
    public function generar(int $ranchoId): array {
        $animales = Animal::where('rancho_id', $ranchoId)
            ->with('registrosPeso')->get();

        return $animales->map(fn($a) => [
            'animal' => $a->nombre,
            'arete'  => $a->numero_arete,
            'gap_kg' => $a->calcularGananciaDiariaPromedio(),
        ])->toArray();
    }
}