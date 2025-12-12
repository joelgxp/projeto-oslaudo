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
        Schema::create('servico_execucoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->json('checklist_preenchido')->nullable();
            $table->json('fotos')->nullable(); // array de URLs
            $table->text('problemas_encontrados')->nullable();
            $table->text('recomendacoes')->nullable();
            $table->text('assinatura_tecnico')->nullable(); // base64
            $table->timestamp('data_assinatura')->nullable();
            $table->enum('status', ['pendente_assinatura', 'assinado'])->default('pendente_assinatura');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servico_execucoes');
    }
};
