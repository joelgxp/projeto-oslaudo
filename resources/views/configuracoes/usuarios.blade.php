@extends('layouts.app')

@section('page-title', 'Gerenciar Usuários')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">Usuários e Técnicos</h1>
            <p style="color: #6b7280; font-size: 0.875rem;">Gerencie usuários do sistema (Administradores e Técnicos). Clientes são cadastrados no módulo de Clientes.</p>
        </div>
        <button onclick="document.getElementById('modalNovoUsuario').style.display='block'" class="btn btn-primary">Novo Usuário</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($usuarios->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Nome</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Email</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Telefone</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Papel</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Status</th>
                        <th style="padding: 0.75rem; text-align: center; font-weight: 600;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem;">{{ $usuario->name }}</td>
                            <td style="padding: 0.75rem;">{{ $usuario->email }}</td>
                            <td style="padding: 0.75rem;">{{ $usuario->phone ?? '-' }}</td>
                            <td style="padding: 0.75rem;">
                                @if($usuario->role === 'admin')
                                    <span class="badge badge-info">Administrador</span>
                                @elseif($usuario->role === 'technician')
                                    <span class="badge badge-success">Técnico</span>
                                @endif
                            </td>
                            <td style="padding: 0.75rem;">
                                <span class="badge {{ $usuario->status === 'ativo' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $usuario->status === 'ativo' ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                @if($usuario->id !== auth()->id())
                                    <form method="POST" action="{{ route('configuracoes.usuarios') }}/toggle/{{ $usuario->id }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                            {{ $usuario->status === 'ativo' ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p style="font-size: 1.125rem;">Nenhum usuário cadastrado.</p>
        </div>
    @endif
</div>

<!-- Modal Novo Usuário -->
<div id="modalNovoUsuario" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); overflow-y: auto; padding: 1rem;">
    <div style="background-color: white; margin: 2% auto; padding: 2rem; border-radius: 0.5rem; width: 90%; max-width: 500px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-shrink: 0; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Novo Usuário</h2>
            <button onclick="document.getElementById('modalNovoUsuario').style.display='none'" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 0.25rem; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'">&times;</button>
        </div>

        <div style="overflow-y: auto; flex: 1; padding-right: 0.5rem; min-height: 0;">
        <form method="POST" action="{{ route('configuracoes.usuarios') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Nome *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" class="form-input" value="{{ old('phone') }}">
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Papel *</label>
                <select name="role" class="form-input" required>
                    <option value="">Selecione</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="technician" {{ old('role') === 'technician' ? 'selected' : '' }}>Técnico</option>
                </select>
                <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">
                    ℹ️ Clientes são cadastrados no módulo de <strong>Clientes</strong>, não precisam de login no sistema.
                </p>
                @error('role')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Senha *</label>
                <input type="password" name="password" class="form-input" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Confirmar Senha *</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-shrink: 0;">
                <button type="submit" class="btn btn-primary">Criar Usuário</button>
                <button type="button" onclick="document.getElementById('modalNovoUsuario').style.display='none'" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<style>
    /* Estilização da barra de scroll do modal */
    #modalNovoUsuario > div > div[style*="overflow-y"]::-webkit-scrollbar {
        width: 8px;
    }
    #modalNovoUsuario > div > div[style*="overflow-y"]::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    #modalNovoUsuario > div > div[style*="overflow-y"]::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    #modalNovoUsuario > div > div[style*="overflow-y"]::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Para Firefox */
    #modalNovoUsuario > div > div[style*="overflow-y"] {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f1f1;
    }
</style>

<script>
    // Fechar modal ao clicar fora
    window.onclick = function(event) {
        const modal = document.getElementById('modalNovoUsuario');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection
