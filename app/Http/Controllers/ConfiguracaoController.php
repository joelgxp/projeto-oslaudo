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
        $user = auth()->user();
        $empresaId = $user->empresa_id;

        if ($request->isMethod('post') || $request->isMethod('put')) {
            $validated = $request->validate([
                'nome_sistema' => 'nullable|string|max:255',
                'tema_sistema' => 'nullable|in:claro,escuro',
                'registros_pagina' => 'nullable|in:10,25,50,100',
            ]);

            // Salvar configurações
            if (isset($validated['nome_sistema'])) {
                \App\Models\ConfiguracaoSistema::set('nome_sistema', $validated['nome_sistema'], $empresaId, 'string', 'Nome do sistema');
            }
            if (isset($validated['tema_sistema'])) {
                \App\Models\ConfiguracaoSistema::set('tema_sistema', $validated['tema_sistema'], $empresaId, 'string', 'Tema do sistema');
            }
            if (isset($validated['registros_pagina'])) {
                \App\Models\ConfiguracaoSistema::set('registros_pagina', $validated['registros_pagina'], $empresaId, 'integer', 'Registros por página');
            }

            return redirect()->route('configuracoes.sistema')
                ->with('success', 'Configurações salvas com sucesso!');
        }
        
        // Carregar configurações existentes
        $configuracoes = [
            'nome_sistema' => \App\Models\ConfiguracaoSistema::get('nome_sistema', $empresaId, 'OSLaudos'),
            'tema_sistema' => \App\Models\ConfiguracaoSistema::get('tema_sistema', $empresaId, 'claro'),
            'registros_pagina' => \App\Models\ConfiguracaoSistema::get('registros_pagina', $empresaId, '10'),
        ];
        
        return view('configuracoes.sistema', compact('configuracoes'));
    }

    public function ordemServico(Request $request)
    {
        $user = auth()->user();
        $empresaId = $user->empresa_id;

        if ($request->isMethod('post') || $request->isMethod('put')) {
            $validated = $request->validate([
                'tecnico_criar_os' => 'nullable|boolean',
                'status_padrao_os' => 'nullable|in:agendado,em_progresso',
                'notificar_tecnico_nova_os' => 'nullable|boolean',
                'notificar_admin_conclusao' => 'nullable|boolean',
                'exigir_assinatura_obrigatoria' => 'nullable|boolean',
            ]);

            // Salvar configurações de OS
            if (isset($validated['tecnico_criar_os'])) {
                \App\Models\ConfiguracaoSistema::set('tecnico_criar_os', $validated['tecnico_criar_os'], $empresaId, 'boolean', 'Permitir técnicos criarem Ordens de Serviço');
            } else {
                \App\Models\ConfiguracaoSistema::set('tecnico_criar_os', false, $empresaId, 'boolean', 'Permitir técnicos criarem Ordens de Serviço');
            }

            if (isset($validated['status_padrao_os'])) {
                \App\Models\ConfiguracaoSistema::set('status_padrao_os', $validated['status_padrao_os'], $empresaId, 'string', 'Status padrão de nova OS');
            }

            if (isset($validated['notificar_tecnico_nova_os'])) {
                \App\Models\ConfiguracaoSistema::set('notificar_tecnico_nova_os', $validated['notificar_tecnico_nova_os'], $empresaId, 'boolean', 'Notificar técnico quando nova OS for atribuída');
            } else {
                \App\Models\ConfiguracaoSistema::set('notificar_tecnico_nova_os', false, $empresaId, 'boolean', 'Notificar técnico quando nova OS for atribuída');
            }

            if (isset($validated['notificar_admin_conclusao'])) {
                \App\Models\ConfiguracaoSistema::set('notificar_admin_conclusao', $validated['notificar_admin_conclusao'], $empresaId, 'boolean', 'Notificar administrador quando OS for concluída');
            } else {
                \App\Models\ConfiguracaoSistema::set('notificar_admin_conclusao', false, $empresaId, 'boolean', 'Notificar administrador quando OS for concluída');
            }

            if (isset($validated['exigir_assinatura_obrigatoria'])) {
                \App\Models\ConfiguracaoSistema::set('exigir_assinatura_obrigatoria', $validated['exigir_assinatura_obrigatoria'], $empresaId, 'boolean', 'Exigir assinatura obrigatória para concluir OS');
            } else {
                \App\Models\ConfiguracaoSistema::set('exigir_assinatura_obrigatoria', false, $empresaId, 'boolean', 'Exigir assinatura obrigatória para concluir OS');
            }

            return redirect()->route('configuracoes.ordem-servico')
                ->with('success', 'Configurações de Ordem de Serviço salvas com sucesso!');
        }
        
        // Carregar configurações existentes
        $configuracoes = [
            'tecnico_criar_os' => \App\Models\ConfiguracaoSistema::get('tecnico_criar_os', $empresaId, false),
            'status_padrao_os' => \App\Models\ConfiguracaoSistema::get('status_padrao_os', $empresaId, 'agendado'),
            'notificar_tecnico_nova_os' => \App\Models\ConfiguracaoSistema::get('notificar_tecnico_nova_os', $empresaId, false),
            'notificar_admin_conclusao' => \App\Models\ConfiguracaoSistema::get('notificar_admin_conclusao', $empresaId, false),
            'exigir_assinatura_obrigatoria' => \App\Models\ConfiguracaoSistema::get('exigir_assinatura_obrigatoria', $empresaId, true),
        ];
        
        return view('configuracoes.ordem-servico', compact('configuracoes'));
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

