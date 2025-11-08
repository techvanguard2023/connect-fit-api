<?php

namespace App\Console\Commands;

use App\Models\Lead\LeadVerification;
use Illuminate\Console\Command;

class CleanExpiredVerifications extends Command
{
    protected $signature = 'leads:clean-verifications';
    protected $description = 'Remove verificações expiradas';

    public function handle()
    {
        $deleted = LeadVerification::where('expires_at', '<', now())
            ->delete();

        $this->info("Removidas {$deleted} verificações expiradas.");
    }
}
