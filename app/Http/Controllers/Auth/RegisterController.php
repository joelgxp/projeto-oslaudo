<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Mostra o formulário de registro
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Processa o registro
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Se não houver empresas, criar uma padrão
        $empresa = \App\Models\Empresa::first();
        if (!$empresa) {
            $empresa = \App\Models\Empresa::create([
                'name' => 'Nova Empresa',
                'cnpj' => '00000000000000',
                'plano' => 'basic',
                'status_pagamento' => 'pendente',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'empresa_id' => $empresa->id,
            'role' => 'admin', // Primeiro usuário sempre será admin
            'status' => 'ativo',
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
