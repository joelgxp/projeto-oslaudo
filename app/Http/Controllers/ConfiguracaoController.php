<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        return view('configuracoes.index');
    }

    public function sistema(Request $request)
    {
        if ($request->isMethod('post') || $request->isMethod('put')) {
            // Aqui você pode salvar as configurações no banco de dados
            // Por enquanto, apenas redireciona com mensagem de sucesso
            return redirect()->route('configuracoes.sistema')
                ->with('success', 'Configurações salvas com sucesso!');
        }
        
        return view('configuracoes.sistema');
    }

    public function usuarios(Request $request)
    {
        $user = auth()->user();
        
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,technician',
                'phone' => 'nullable|string|max:20',
            ]);

            $validated['password'] = bcrypt($validated['password']);
            $validated['empresa_id'] = $user->empresa_id;
            $validated['status'] = 'ativo';

            \App\Models\User::create($validated);

            return redirect()->route('configuracoes.usuarios')
                ->with('success', 'Usuário criado com sucesso!');
        }

        $usuarios = \App\Models\User::where('empresa_id', $user->empresa_id)
            ->orderBy('name')
            ->get();

        return view('configuracoes.usuarios', compact('usuarios'));
    }

    public function toggleUsuario($id)
    {
        $user = auth()->user();
        $usuario = \App\Models\User::where('id', $id)
            ->where('empresa_id', $user->empresa_id)
            ->firstOrFail();

        if ($usuario->id === $user->id) {
            return redirect()->route('configuracoes.usuarios')
                ->with('error', 'Você não pode alterar seu próprio status.');
        }

        $usuario->status = $usuario->status === 'ativo' ? 'inativo' : 'ativo';
        $usuario->save();

        return redirect()->route('configuracoes.usuarios')
            ->with('success', 'Status do usuário atualizado com sucesso!');
    }

    public function emitente()
    {
        return view('configuracoes.emitente');
    }

    public function permissoes()
    {
        return view('configuracoes.permissoes');
    }

    public function auditoria()
    {
        return view('configuracoes.auditoria');
    }

    public function emails(Request $request)
    {
        if ($request->isMethod('post')) {
            // Aqui você pode salvar as configurações de e-mail no banco de dados
            // Por enquanto, apenas redireciona com mensagem de sucesso
            return redirect()->route('configuracoes.emails')
                ->with('success', 'Configurações de e-mail salvas com sucesso!');
        }
        
        return view('configuracoes.emails');
    }

    public function backup()
    {
        return view('configuracoes.backup');
    }
}

