<?php

namespace App\Jobs;

use App\Models\Lead\Lead;
use App\Services\EvolutionApi\EvolutionWhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;
    public int $backoff = 10;

    public function __construct(
        public Lead $lead,
        public string $code
    ) {}

    public function handle(EvolutionWhatsAppService $whatsapp): void
    {
        $sent = $whatsapp->sendVerificationCode($this->lead, $this->code);
        
        if (!$sent && $this->attempts() < $this->tries) {
            $this->release(10); // Tentar novamente em 10 segundos
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Job de envio de WhatsApp falhou', [
            'lead_id' => $this->lead->id,
            'code' => $this->code,
            'error' => $exception->getMessage()
        ]);
    }
}
