<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar empresa padrão
        $empresa = Empresa::firstOrCreate(
            ['cnpj' => '00000000000000'],
            [
                'name' => 'Empresa Padrão',
                'telefone' => '(00) 0000-0000',
                'plano' => 'pro',
                'status_pagamento' => 'ativo',
            ]
        );

        // Criar usuário admin padrão
        User::firstOrCreate(
            ['email' => 'admin@oslaudos.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@oslaudos.com',
                'password' => Hash::make('admin123'),
                'empresa_id' => $empresa->id,
                'role' => 'admin',
                'status' => 'ativo',
            ]
        );

        $this->command->info('Usuário admin criado com sucesso!');
        $this->command->info('Email: admin@oslaudos.com');
        $this->command->info('Senha: admin123');
    }
}
