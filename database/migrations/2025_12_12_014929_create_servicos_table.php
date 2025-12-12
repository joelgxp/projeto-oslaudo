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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('tipo_servico');
            $table->date('data_agendada')->nullable();
            $table->date('data_execucao')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fim')->nullable();
            $table->text('endereco_servico')->nullable();
            $table->text('descricao_servico')->nullable();
            $table->text('observacoes')->nullable();
            $table->enum('status', ['agendado', 'em_progresso', 'concluido', 'cancelado'])->default('agendado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
