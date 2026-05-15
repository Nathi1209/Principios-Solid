<?php
namespace App\Services;

use App\Contracts\ReporteInterface;
use InvalidArgumentException;

class ReporteService {
    /**
     * @var ReporteInterface[]
     */
    protected array $reportes = [];

    /**
     * Permite extender el sistema con nuevos reportes sin modificar esta clase.
     */
    public function registrarReporte(string $tipo, ReporteInterface $reporte): void {
        $this->reportes[$tipo] = $reporte;
    }

    /**
     * Genera el reporte solicitado.
     */
    public function generar(string $tipo, int $ranchoId): array {
        if (!isset($this->reportes[$tipo])) {
            throw new InvalidArgumentException("Tipo de reporte desconocido: {$tipo}");
        }

        return $this->reportes[$tipo]->generar($ranchoId);
    }
}