<?php
namespace App\Services;

use App\Models\Animal;
use App\Models\RegistroPeso;
use App\Contracts\IEstimadorPeso;
use InvalidArgumentException;

class EstimadorPesoService {
    protected $estimador;

    // Inyección de la abstracción (DIP en acción)
    public function __construct(IEstimadorPeso $estimador) {
        $this->estimador = $estimador;
    }

    public function estimar(int $animalId, array $urlsFotos): RegistroPeso {
        // --- Validación (Lógica de negocio intacta) ---
        if (empty($urlsFotos)) {
            throw new InvalidArgumentException('Se requiere al menos una fotografia.');
        }
        if (count($urlsFotos) > 5) {
            throw new InvalidArgumentException('Máximo 5 fotografias por sesión.');
        }

        $animal = Animal::findOrFail($animalId);

        // --- Uso de la abstracción (Ya no hay Http::post directo) ---
        $datos = $this->estimador->obtenerEstimacion(
            $urlsFotos, 
            $animal->raza->nombre, 
            $animal->calcularEdadEnMeses()
        );

        // --- Persistencia del resultado ---
        return RegistroPeso::create([
            'animal_id'           => $animalId,
            'peso_kg'             => $datos['estimated_weight_kg'],
            'confianza_porcentaje'=> $datos['confidence'] * 100,
            'metodo_estimacion'   => 'yolov8',
            'fecha'               => now(),
        ]);
    }
}