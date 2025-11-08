<?php

namespace App\Services;

use App\Models\Lead\Lead;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function sendVerificationCode(Lead $lead, string $code): bool
    {
        // Exemplo usando Twilio
        $response = Http::withBasicAuth(
            config('services.twilio.sid'),
            config('services.twilio.token')
        )->post("https://api.twilio.com/2010-04-01/Accounts/" . config('services.twilio.sid') . "/Messages.json", [
            'From' => 'whatsapp:' . config('services.twilio.whatsapp_number'),
            'To' => 'whatsapp:' . $lead->phone,
            'Body' => "Seu código de verificação é: {$code}\n\nVálido por 10 minutos."
        ]);

        return $response->successful();
    }
}
