<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lead_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->string('code', 6)->index();
            $table->timestamp('expires_at')->index();
            $table->timestamp('verified_at')->nullable();
            $table->integer('attempts')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            
            // Índices compostos para performance
            $table->index(['lead_id', 'expires_at']);
            $table->index(['code', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_verifications');
    }
};
