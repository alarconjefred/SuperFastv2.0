<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Procesa la consulta del usuario, inyecta el contexto controlado desde el servidor
     * y se comunica de forma autenticada con el microservicio de IA en Vercel,
     * soportando bypass oficial de Deployment Protection y token de servicio de aplicación.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        // 1. Validación estricta de entrada
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:500'],
        ]);

        $userText = trim($validated['message']);

        // 2. Parámetros controlados 100% por el servidor (el navegador no puede inyectar prompts arbitrarios)
        $systemInstruction = "Eres el asistente virtual oficial de SuperFast, la plataforma líder de comercio local y entrega de domicilios.\n"
            . "Tu misión es responder dudas de clientes, comercios y repartidores sobre pedidos, catálogos, registro de negocios y uso de la plataforma.\n"
            . "Reglas:\n"
            . "- Responde siempre en español de forma concisa, respetuosa y profesional.\n"
            . "- Usa viñetas o negritas simples cuando sea útil.\n"
            . "- No inventes precios exactos ni prometas promociones no verificadas.\n"
            . "- Si te preguntan cosas ajenas a SuperFast, indica amablemente que solo puedes ayudar con temas relacionados a la plataforma.";

        $contextChunks = "INFORMACIÓN INSTITUCIONAL DE SUPERFAST:\n"
            . "- SuperFast conecta a clientes con comercios, tiendas de barrio y restaurantes de la región.\n"
            . "- Clientes: pueden explorar categorías, consultar productos, gestionar su carrito y solicitar domicilios rápidos.\n"
            . "- Comercios/Empresas: cuentan con panel de administración para registrar su negocio, publicar productos, controlar inventario y gestionar pedidos recibidos.\n"
            . "- Repartidores: cuentan con panel para visualización de entregas y asignación de rutas activas.\n"
            . "- Pagos: tarjetas de crédito/débito, PSE y pago contra entrega según la política de cada comercio.\n"
            . "- Soporte: disponible en la plataforma para incidencias con pedidos y registros.";

        // 3. Obtención segura de credenciales de servicio (nunca expuestas al frontend)
        $vercelUrl = config('services.chatbot.url') ?: env('CHATBOT_VERCEL_URL', 'https://chat-bot-ten-sage.vercel.app/api/chat');
        $serviceToken = config('services.chatbot.token') ?: env('CHATBOT_SERVICE_TOKEN');
        $bypassSecret = config('services.chatbot.bypass_secret') ?: env('VERCEL_AUTOMATION_BYPASS_SECRET');

        if (empty($serviceToken)) {
            Log::warning('[SuperFast Chatbot] CHATBOT_SERVICE_TOKEN no está configurado en el archivo .env de Laravel.');
            return response()->json([
                'error' => 'El servicio de chatbot no está configurado de forma segura en el servidor.'
            ], 503);
        }

        // 4. Preparación de encabezados seguros
        $headers = [
            'X-Chatbot-Key' => $serviceToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        // Header oficial de Vercel para Protection Bypass for Automation (si está configurado)
        if (!empty($bypassSecret)) {
            $headers['x-vercel-protection-bypass'] = $bypassSecret;
        }

        // 5. Petición HTTP servidor-a-servidor hacia Vercel
        try {
            $response = Http::timeout(45)
                ->withHeaders($headers)
                ->post($vercelUrl, [
                    'userText' => $userText,
                    'systemInstruction' => $systemInstruction,
                    'contextChunks' => $contextChunks,
                ]);

            if ($response->successful()) {
                $reply = $response->json('reply');
                if (!empty($reply) && is_string($reply)) {
                    return response()->json(['reply' => $reply]);
                }
                return response()->json(['error' => 'Formato de respuesta inesperado del servicio de IA.'], 502);
            }

            // Manejo de códigos de estado específicos de Vercel
            $status = $response->status();

            if ($status === 401 || $status === 403) {
                $body = $response->body();
                // Distinguir entre rechazo de Vercel Deployment Protection y rechazo de la aplicación Chatbot
                if (str_contains($body, 'Protected by Vercel Authentication') || str_contains($body, 'vercel_auth')) {
                    Log::warning('[SuperFast Chatbot] Bloqueado por Vercel Deployment Protection. Falta o es inválido VERCEL_AUTOMATION_BYPASS_SECRET.');
                    return response()->json([
                        'error' => 'El servicio en Vercel requiere autorización de bypass de protección. Verifica VERCEL_AUTOMATION_BYPASS_SECRET.'
                    ], 502);
                }

                Log::warning("[SuperFast Chatbot] Error de autenticación de token con el chatbot ({$status}).");
                return response()->json([
                    'error' => 'Error de autenticación con el servicio de IA. Verifica que CHATBOT_SERVICE_TOKEN coincida.'
                ], 502);
            }

            if ($status === 429) {
                return response()->json([
                    'error' => 'El servicio de IA ha recibido demasiadas solicitudes consecutivas. Por favor espera un momento.'
                ], 429);
            }

            Log::error("[SuperFast Chatbot] Vercel respondió con error HTTP {$status}: " . $response->body());
            return response()->json([
                'error' => 'No fue posible obtener respuesta del asistente virtual en este momento.'
            ], 502);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('[SuperFast Chatbot] Tiempo de espera agotado al conectar con Vercel: ' . $e->getMessage());
            return response()->json([
                'error' => 'Tiempo de espera agotado al comunicar con el servicio de IA en Vercel.'
            ], 504);
        } catch (\Throwable $e) {
            Log::error('[SuperFast Chatbot] Excepción general: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error interno al procesar el mensaje con el chatbot.'
            ], 500);
        }
    }
}
