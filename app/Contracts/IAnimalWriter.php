<?php

namespace App\Contracts;

interface IAnimalWriter
{
    public function crear(array $datos);
    public function actualizar(int $id, array $datos);
    public function eliminar(int $id): void;
}