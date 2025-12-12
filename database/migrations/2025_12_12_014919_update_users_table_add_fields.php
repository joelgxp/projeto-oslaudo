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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->onDelete('set null')->after('phone');
            $table->enum('role', ['admin', 'technician', 'client'])->default('client')->after('empresa_id');
            $table->enum('status', ['ativo', 'inativo'])->default('ativo')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn(['phone', 'empresa_id', 'role', 'status']);
        });
    }
};
