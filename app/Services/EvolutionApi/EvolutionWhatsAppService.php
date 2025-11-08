<?php

namespace App\Services\EvolutionApi;

use App\Models\Lead\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class EvolutionWhatsAppService
{
    private string $baseUrl;
    private string $apiKey;
    private string $instance;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.evolution.url'), '/');
        $this->apiKey = config('services.evolution.api_key');
        $this->instance = config('services.evolution.instance');
    }

    public function sendVerificationCode(Lead $lead, string $code): bool
    {
        try {
            $message = $this->buildVerificationMessage($code);
            $phone = $this->formatPhoneNumber($lead->phone);
            
            // Payload simples
            $payload = [
                'number' => $phone,
                'textMessage' => [
                    'text' => $message
                ]
            ];
            
            Log::info('Enviando WhatsApp (payload simples)', [
                'lead_id' => $lead->id,
                'payload' => $payload
            ]);
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'apikey' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post("{$this->baseUrl}/message/sendText/{$this->instance}", $payload);

            Log::info('Resposta Evolution API', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return $response->successful();

        } catch (Exception $e) {
            Log::error('Exceção WhatsApp', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }


    public function sendWelcomeMessage(Lead $lead): bool
    {
        $message = "✅ *Verificação Concluída!*\n\n" .
                   "Olá, {$lead->name}!\n\n" .
                   "Sua conta foi verificada com sucesso. " .
                   "Em breve entraremos em contato.";

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'apikey' => $this->apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post("{$this->baseUrl}/message/sendText/{$this->instance}", [
                    'number' => $this->formatPhoneNumber($lead->phone),
                    'textMessage' => [
                        'text' => $message
                    ]
                ]);

            return $response->successful();

        } catch (Exception $e) {
            Log::error('Erro ao enviar mensagem de boas-vindas', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function checkConnection(): array
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey
            ])->get("{$this->baseUrl}/instance/connectionState/{$this->instance}");

            if ($response->successful()) {
                return [
                    'connected' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'connected' => false,
                'error' => $response->body()
            ];

        } catch (Exception $e) {
            return [
                'connected' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (!str_starts_with($phone, '55')) {
            $phone = '55' . $phone;
        }
        
        return $phone;
    }

    private function buildVerificationMessage(string $code): string
    {
        return "🔐 *Código de Verificação*\n\n" .
               "Seu código é: *{$code}*\n\n" .
               "⏰ Válido por 10 minutos\n" .
               "🔒 Não compartilhe este código com ninguém.";
    }
}
