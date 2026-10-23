<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class ChatbotEndpointTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('services.chatbot.url', 'https://chat-bot-ten-sage.vercel.app/api/chat');
        Config::set('services.chatbot.token', 'test_secret_token_123456');
        Config::set('services.chatbot.bypass_secret', 'test_bypass_secret_abcdef');
    }

    public function test_message_is_required_for_chatbot(): void
    {
        $response = $this->postJson(route('chatbot.message'), []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['message']);
    }

    public function test_message_cannot_exceed_500_characters(): void
    {
        $longMessage = str_repeat('a', 501);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => $longMessage
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['message']);
    }

    public function test_chatbot_forwards_message_and_headers_when_vercel_succeeds(): void
    {
        Http::fake([
            'https://chat-bot-ten-sage.vercel.app/api/chat' => Http::response([
                'reply' => '¡Hola! Soy el asistente virtual de SuperFast.'
            ], 200)
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => '¿Qué servicios ofrece SuperFast?'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'reply' => '¡Hola! Soy el asistente virtual de SuperFast.'
                 ]);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://chat-bot-ten-sage.vercel.app/api/chat' &&
                   $request->hasHeader('X-Chatbot-Key', 'test_secret_token_123456') &&
                   $request->hasHeader('x-vercel-protection-bypass', 'test_bypass_secret_abcdef') &&
                   $request['userText'] === '¿Qué servicios ofrece SuperFast?' &&
                   isset($request['systemInstruction']) &&
                   isset($request['contextChunks']);
        });
    }

    public function test_chatbot_handles_vercel_deployment_protection_gracefully(): void
    {
        Http::fake([
            'https://chat-bot-ten-sage.vercel.app/api/chat' => Http::response(
                '{"error":{"message":"Protected deployment","code":"401"},"message":"Protected by Vercel Authentication"}',
                401
            )
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Hola'
        ]);

        $response->assertStatus(502)
                 ->assertJsonStructure(['error']);

        $this->assertStringNotContainsString('test_secret_token_123456', $response->getContent());
        $this->assertStringNotContainsString('test_bypass_secret_abcdef', $response->getContent());
    }

    public function test_chatbot_handles_token_auth_error_gracefully(): void
    {
        Http::fake([
            'https://chat-bot-ten-sage.vercel.app/api/chat' => Http::response([
                'error' => 'Acceso no autorizado al servicio de IA.'
            ], 401)
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Hola'
        ]);

        $response->assertStatus(502)
                 ->assertJsonStructure(['error']);

        $this->assertStringNotContainsString('test_secret_token_123456', $response->getContent());
    }

    public function test_chatbot_handles_rate_limiting_from_vercel(): void
    {
        Http::fake([
            'https://chat-bot-ten-sage.vercel.app/api/chat' => Http::response([
                'error' => 'Demasiadas peticiones. Intenta de nuevo en un minuto.'
            ], 429)
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Hola'
        ]);

        $response->assertStatus(429)
                 ->assertJsonStructure(['error']);
    }

    public function test_chatbot_handles_server_error_from_vercel(): void
    {
        Http::fake([
            'https://chat-bot-ten-sage.vercel.app/api/chat' => Http::response([
                'error' => 'Error interno del servidor al procesar con Gemini.'
            ], 500)
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Hola'
        ]);

        $response->assertStatus(502)
                 ->assertJsonStructure(['error']);
    }

    public function test_chatbot_handles_timeout_gracefully(): void
    {
        Http::fake(function () {
            throw new \Illuminate\Http\Client\ConnectionException('Connection timed out after 15000 milliseconds');
        });

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Hola'
        ]);

        $response->assertStatus(504)
                 ->assertJson([
                     'error' => 'Tiempo de espera agotado al comunicar con el servicio de IA en Vercel.'
                 ]);
    }
}
