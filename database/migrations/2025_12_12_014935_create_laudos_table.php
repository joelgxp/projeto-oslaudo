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
        Schema::create('laudos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained('laudo_templates')->onDelete('set null');
            $table->text('conteudo_html')->nullable();
            $table->string('arquivo_pdf')->nullable(); // caminho relativo
            $table->boolean('assinado')->default(false);
            $table->timestamp('data_assinatura_cliente')->nullable();
            $table->text('assinatura_cliente_base64')->nullable();
            $table->enum('metodo_assinatura', ['biometria', 'canvas'])->nullable();
            $table->enum('status', ['rascunho', 'enviado', 'assinado', 'arquivado'])->default('rascunho');
            $table->uuid('link_assinatura_unico')->unique()->nullable();
            $table->timestamp('expira_em')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laudos');
    }
};
