<?php
namespace App\Services;

use App\Contracts\IEstimadorPeso;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class YoloWeightEstimator implements IEstimadorPeso {
    private string $url = 'http://localhost:5000/estimate';

    public function obtenerEstimacion(array $urlsFotos, string $raza, int $edadMeses): array {
        $respuesta = Http::timeout(30)->post($this->url, [
            'image_urls'  => $urlsFotos,
            'breed'       => $raza,
            'age_months'  => $edadMeses,
        ]);

        if (!$respuesta->successful()) {
            throw new RuntimeException('El servicio de estimación ML no respondió correctamente.');
        }

        return $respuesta->json();
    }
}