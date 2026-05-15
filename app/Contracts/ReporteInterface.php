<?php
namespace App\Contracts;

interface ReporteInterface {
    public function generar(int $ranchoId): array;
}