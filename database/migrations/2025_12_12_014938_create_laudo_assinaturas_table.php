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
        Schema::create('laudo_assinaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laudo_id')->constrained('laudos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('ip_cliente')->nullable();
            $table->string('navegador')->nullable();
            $table->string('dispositivo')->nullable();
            $table->enum('metodo_assinatura', ['biometria', 'canvas']);
            $table->text('assinatura_base64');
            $table->timestamp('timestamp_assinatura');
            $table->string('hash_integridade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laudo_assinaturas');
    }
};
