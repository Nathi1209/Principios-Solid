<?php

namespace App\Contracts;

interface IAnimalReader
{
    public function buscarPorArete(string $arete);
    public function listarPorRancho(int $ranchoId): array;
    public function obtenerHistorialPeso(int $animalId): array;
}