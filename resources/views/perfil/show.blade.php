@extends('layouts.app')

@section('page-title', 'Meu Perfil')

@section('content')
<div class="card">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Meu Perfil</h1>
        <p style="color: #6b7280; margin-top: 0.5rem;">Gerencie suas informações pessoais e senha</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom: 2rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.update') }}" id="perfilForm">
        @csrf
        @method('PUT')

        <div style="display: grid; gap: 2rem;">
            <!-- Informações Pessoais -->
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #2563eb; padding-bottom: 0.75rem; border-bottom: 2px solid #e5e7eb;">
                    Informações Pessoais
                </h2>
                
                <div style="display: grid; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="(00) 00000-0000">
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informações da Conta -->
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #2563eb; padding-bottom: 0.75rem; border-bottom: 2px solid #e5e7eb;">
                    Informações da Conta
                </h2>
                
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <div style="display: grid; gap: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="font-weight: 500; color: #374151;">Função:</span>
                            <span style="text-transform: capitalize; color: #6b7280;">
                                @if($user->isAdmin())
                                    Administrador
                                @elseif($user->isTechnician())
                                    Técnico
                                @else
                                    Cliente
                                @endif
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="font-weight: 500; color: #374151;">Status:</span>
                            <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $user->status === 'active' ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0;">
                            <span style="font-weight: 500; color: #374151;">Membro desde:</span>
                            <span style="color: #6b7280;">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alterar Senha -->
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; color: #2563eb; padding-bottom: 0.75rem; border-bottom: 2px solid #e5e7eb;">
                    Alterar Senha
                </h2>
                <p style="color: #6b7280; margin-bottom: 1.5rem; font-size: 0.875rem;">
                    Deixe os campos de senha em branco se não desejar alterar.
                </p>
                
                <div style="display: grid; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Senha Atual</label>
                        <input type="password" name="current_password" class="form-input" placeholder="Digite sua senha atual">
                        @error('current_password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nova Senha</label>
                        <input type="password" name="password" class="form-input" placeholder="Digite a nova senha">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">
                            Mínimo de 8 caracteres
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirmar Nova Senha</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Confirme a nova senha">
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn btn-primary" style="min-width: 200px;">
                Salvar Alterações
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="min-width: 200px;">
                Cancelar
            </a>
        </div>
    </form>
</div>

<style>
    @media (max-width: 768px) {
        .card {
            padding: 1rem;
        }

        h1 {
            font-size: 1.5rem !important;
        }

        h2 {
            font-size: 1.25rem !important;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<script>
    // Máscara para telefone
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector('input[name="phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length <= 11) {
                    if (value.length <= 10) {
                        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                    } else {
                        value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                    }
                    e.target.value = value;
                }
            });
        }

        // Validação de senha em tempo real
        const passwordInput = document.querySelector('input[name="password"]');
        const passwordConfirmInput = document.querySelector('input[name="password_confirmation"]');
        
        function validatePassword() {
            if (passwordInput.value && passwordConfirmInput.value) {
                if (passwordInput.value !== passwordConfirmInput.value) {
                    passwordConfirmInput.setCustomValidity('As senhas não coincidem');
                } else {
                    passwordConfirmInput.setCustomValidity('');
                }
            } else {
                passwordConfirmInput.setCustomValidity('');
            }
        }

        if (passwordInput && passwordConfirmInput) {
            passwordInput.addEventListener('input', validatePassword);
            passwordConfirmInput.addEventListener('input', validatePassword);
        }
    });
</script>
@endsection

