<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BonusController extends Controller
{
    public function index()
    {
        try {
            // Consumir API externa
            $response = Http::get('https://jsonplaceholder.typicode.com/users');

            // Verificar que la respuesta sea correcta
            if ($response->successful()) {
                // Convertir JSON a array
                $users = $response->json();
            } else {

                Log::error('Error al consumir API', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                $users = [];
            }
        } catch (\Exception $e) {
            Log::error('Excepción al consumir API', [
                'message' => $e->getMessage()
            ]);

            $users = [];
        }

        return view('payments.bonus', compact('users'));
    }
}
