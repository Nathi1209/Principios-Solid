<?php

namespace App\Models;

// Esta clase extiende de Animal para heredar los datos básicos
class AnimalConPeso extends Animal
{
    /**
     * Ahora el contrato es seguro. Solo las instancias de esta clase 
     * permiten registros de peso[cite: 172, 177].
     */
    public function agregarRegistroPeso($registro): void
    {
        // Aquí iría la lógica para guardar el peso en la DB
    }

    public function calcularGananciaDiariaPromedio(): float
    {
        // El padre ya no se ve forzado a retornar null o error [cite: 183, 184]
        return 0.0; 
    }
}