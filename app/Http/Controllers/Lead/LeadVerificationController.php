<?php

namespace App\Http\Controllers\Lead;

use App\Http\Controllers\Controller;

use App\Models\Lead\Lead;
use App\Models\Lead\LeadVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Services\EvolutionApi\EvolutionWhatsAppService;
use App\Jobs\SendWhatsAppVerificationJob;


class LeadVerificationController extends Controller
{
    public function store(Request $request)
    {
        // Rate limiting
        $key = 'create-lead:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'phone' => ["Muitas tentativas. Tente novamente em {$seconds} segundos."]
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'type' => 'required|string',
            'opt_in' => 'boolean'
        ]);

        // Criar lead
        $lead = Lead::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'status' => 'not_verified'
        ]);

        // Limpar verificações anteriores pendentes
        $lead->verifications()
            ->whereNull('verified_at')
            ->delete();

        // Criar nova verificação
        $verification = LeadVerification::create([
            'lead_id' => $lead->id,
            'code' => LeadVerification::generateCode(),
            'expires_at' => now()->addMinutes(10),
            'ip_address' => $request->ip()
        ]);

        // Enviar código via WhatsApp
        $this->sendWhatsAppCode($lead, $verification->code);

        RateLimiter::hit($key, 300);

        return response()->json([
            'success' => true,
            'lead_id' => $lead->id,
            'message' => 'Código enviado via WhatsApp'
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'code' => 'required|digits:6'
        ]);

        $lead = Lead::findOrFail($validated['lead_id']);
        $verification = $lead->getActiveVerification();

        if (!$verification) {
            throw ValidationException::withMessages([
                'code' => ['Nenhum código ativo encontrado. Solicite um novo.']
            ]);
        }

        if (!$verification->isValid()) {
            throw ValidationException::withMessages([
                'code' => ['Código expirado ou excedeu tentativas máximas.']
            ]);
        }

        if ($verification->code !== $validated['code']) {
            $verification->incrementAttempts();
            throw ValidationException::withMessages([
                'code' => ['Código inválido.']
            ]);
        }

        // Verificação bem-sucedida
        $verification->markAsVerified();
        $lead->markAsVerified();

        // Enviar mensagem de boas-vindas
        $whatsapp = app(EvolutionWhatsAppService::class);
        $whatsapp->sendWelcomeMessage($lead);

        return response()->json([
            'success' => true,
            'message' => 'Lead verificado com sucesso!'
        ]);
    }


    public function resend(Request $request)
    {
        $key = 'resend-code:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 2)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'lead_id' => ["Aguarde {$seconds} segundos para reenviar."]
            ]);
        }

        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id'
        ]);

        $lead = Lead::findOrFail($validated['lead_id']);

        // Limpar verificações anteriores
        $lead->verifications()
            ->whereNull('verified_at')
            ->delete();

        // Criar nova verificação
        $verification = LeadVerification::create([
            'lead_id' => $lead->id,
            'code' => LeadVerification::generateCode(),
            'expires_at' => now()->addMinutes(10),
            'ip_address' => $request->ip()
        ]);

        $this->sendWhatsAppCode($lead, $verification->code);

        RateLimiter::hit($key, 120);

        return response()->json([
            'success' => true,
            'message' => 'Novo código enviado'
        ]);
    }

    private function sendWhatsAppCode(Lead $lead, string $code)
    {
        // Envio síncrono (útil para debug)
        // $whatsapp = app(EvolutionWhatsAppService::class);
        // return $whatsapp->sendVerificationCode($lead, $code);
        
        // Envio assíncrono (recomendado para produção)
        dispatch(new SendWhatsAppVerificationJob($lead, $code));
    }

}

