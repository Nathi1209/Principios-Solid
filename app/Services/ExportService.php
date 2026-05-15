<?php
namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class ExportService {
    public function generarPdfRegistro($animal, $ranchoId) {
        // Obtenemos el propietario para el reporte (siguiendo la lógica del profe)
        $propietario = \Illuminate\Support\Facades\DB::table('propietarios')
            ->where('rancho_id', $ranchoId)->first();

        $pdf = Pdf::loadView('reportes.registro_animal', [
            'animal' => $animal,
            'propietario' => $propietario,
            'fecha' => now()->format('d/m/Y H:i'),
        ]);

        $rutaPdf = 'registros/' . $animal->numero_arete . '_' . now()->timestamp . '.pdf';
        
        $pdf->save(storage_path('app/public/' . $rutaPdf));
        
        return $rutaPdf;
    }
}