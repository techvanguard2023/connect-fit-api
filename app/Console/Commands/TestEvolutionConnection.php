<?php

namespace App\Console\Commands;

use App\Services\EvolutionApi\EvolutionWhatsAppService;
use Illuminate\Console\Command;

class TestEvolutionConnection extends Command
{
    protected $signature = 'evolution:test';
    protected $description = 'Testa conexão com Evolution API';

    public function handle(EvolutionWhatsAppService $whatsapp)
    {
        $this->info('Testando conexão com Evolution API...');
        
        $result = $whatsapp->checkConnection();
        
        if ($result['connected']) {
            $this->info('✅ Conexão estabelecida com sucesso!');
            $this->line(json_encode($result['data'], JSON_PRETTY_PRINT));
        } else {
            $this->error('❌ Falha na conexão');
            $this->error($result['error']);
        }
    }
}
