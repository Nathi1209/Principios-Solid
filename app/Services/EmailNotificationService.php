<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService {
    public function enviarNotificacionRegistro($animal, $ranchoId) {
        $propietario = DB::table('propietarios')
            ->where('rancho_id', $ranchoId)->first();

        $cuerpoEmail = '<h1>Registro exitoso</h1>';
        $cuerpoEmail .= '<p>Animal: ' . $animal->nombre . '</p>';
        $cuerpoEmail .= '<p>Arete: ' . $animal->numero_arete . '</p>';
        $cuerpoEmail .= '<p>Peso inicial: ' . $animal->peso_inicial_kg . ' kg</p>';

        Mail::raw($cuerpoEmail, function ($message) use ($propietario) {
            $message->to($propietario->email)
                    ->subject('BovWeight CR Nuevo animal registrado');
        });
    }
}