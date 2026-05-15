<?php
namespace App\Services;

use App\Models\Animal;
use App\Services\EmailNotificationService;
use App\Services\ExportService;
use InvalidArgumentException;

class AnimalService {
    protected $notificationService;
    protected $exportService;

    // Inyectamos los nuevos servicios para cumplir con SRP
    public function __construct(
        EmailNotificationService $notificationService, 
        ExportService $exportService
    ) {
        $this->notificationService = $notificationService;
        $this->exportService = $exportService;
    }

    /**
     * Registra un animal, notifica al propietario y genera el PDF del registro.
     */
    public function registrar(array $datos): Animal {
        // --- Lógica de negocio (Copiada tal cual del PDF) ---
        if (empty($datos['numero_arete'])) {
            throw new InvalidArgumentException('El arete es obligatorio.');
        }
        if ($datos['peso_inicial_kg'] <= 0) {
            throw new InvalidArgumentException('El peso inicial debe ser positivo.');
        }

        $animal = Animal::create([
            'numero_arete'      => $datos['numero_arete'],
            'nombre'            => $datos['nombre'],
            'raza_id'           => $datos['raza_id'],
            'rancho_id'         => $datos['rancho_id'],
            'peso_inicial_kg'   => $datos['peso_inicial_kg'],
            'fecha_nacimiento'  => $datos['fecha_nacimiento'],
        ]);

        // --- Delegación de responsabilidades (SOLID) ---
        
        // 1. Notificación
        $this->notificationService->enviarNotificacionRegistro($animal, $datos['rancho_id']);

        // 2. Exportación
        $rutaPdf = $this->exportService->generarPdfRegistro($animal, $datos['rancho_id']);

        // Actualizamos la ruta en el modelo como hacía el código original
        $animal->update(['ruta_pdf_registro' => $rutaPdf]);

        return $animal;
    }
}