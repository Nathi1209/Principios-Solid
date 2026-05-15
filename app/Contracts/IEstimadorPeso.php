<?php
namespace App\Contracts;

interface IEstimadorPeso {
    public function obtenerEstimacion(array $urlsFotos, string $raza, int $edadMeses): array;
}