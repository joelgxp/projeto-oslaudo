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
        Schema::create('laudo_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('tipo_servico');
            $table->string('nome_template');
            $table->text('conteudo_html'); // template com {{campos}}
            $table->json('campos_obrigatorios')->nullable();
            $table->json('campos_opcionais')->nullable();
            $table->foreignId('criado_por')->constrained('users')->onDelete('cascade');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laudo_templates');
    }
};
