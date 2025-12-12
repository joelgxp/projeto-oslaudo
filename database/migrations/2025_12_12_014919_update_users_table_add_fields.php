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
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'empresa_id')) {
                $table->foreignId('empresa_id')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'technician', 'client'])->default('client')->after('empresa_id');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['ativo', 'inativo'])->default('ativo')->after('role');
            }
        });

        // Adicionar foreign key separadamente se não existir
        if (Schema::hasTable('empresas')) {
            Schema::table('users', function (Blueprint $table) {
                $foreignKeys = Schema::getConnection()
                    ->getDoctrineSchemaManager()
                    ->listTableForeignKeys('users');
                
                $hasForeignKey = false;
                foreach ($foreignKeys as $foreignKey) {
                    if ($foreignKey->getName() === 'users_empresa_id_foreign') {
                        $hasForeignKey = true;
                        break;
                    }
                }
                
                if (!$hasForeignKey && Schema::hasColumn('users', 'empresa_id')) {
                    $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
                }
            });
        }
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
