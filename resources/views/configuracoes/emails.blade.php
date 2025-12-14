@extends('layouts.app')

@section('page-title', 'Configurar')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Configurações do Sistema</h1>

    <!-- Tabs -->
    <div style="border-bottom: 2px solid var(--border-color); margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 0;">
            <a href="{{ route('configuracoes.sistema') }}" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">Gerais</a>
            <a href="#" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">Notificações</a>
            <a href="#" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">Atualizações</a>
            <a href="{{ route('configuracoes.emails') }}" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid #fb923c; color: var(--text-primary); font-weight: 600; text-decoration: none; font-size: 0.8125rem;">E-mail</a>
        </div>
    </div>

    <!-- Formulário E-mail -->
    <form method="POST" action="{{ route('configuracoes.emails') }}">
        @csrf

        <div style="display: grid; gap: 1.5rem;">
            <!-- Protocolo de E-mail -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="protocolo_email" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Protocolo de E-mail
                </label>
                <div style="flex: 1;">
                    <input 
                        type="text" 
                        id="protocolo_email" 
                        name="protocolo_email" 
                        value="{{ old('protocolo_email', 'smtp') }}"
                        class="form-input"
                        style="width: 100%; max-width: 400px;"
                    >
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Informe o protocolo que será utilizado</p>
                </div>
            </div>

            <!-- Endereço do Host -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="host_email" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Endereço do Host
                </label>
                <div style="flex: 1;">
                    <input 
                        type="text" 
                        id="host_email" 
                        name="host_email" 
                        value="{{ old('host_email', 'smtp.gmail.com') }}"
                        class="form-input"
                        style="width: 100%; max-width: 400px;"
                    >
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Informe o endereço do host</p>
                </div>
            </div>

            <!-- Tipo de criptografia -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="tipo_criptografia" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Tipo de criptografia
                </label>
                <div style="flex: 1;">
                    <select 
                        id="tipo_criptografia" 
                        name="tipo_criptografia" 
                        class="form-select"
                        style="width: 100%; max-width: 400px;"
                        onchange="updatePorta()"
                    >
                        <option value="tls" {{ old('tipo_criptografia', 'tls') === 'tls' ? 'selected' : '' }}>TLS (Recomendado - Porta 587)</option>
                        <option value="ssl" {{ old('tipo_criptografia') === 'ssl' ? 'selected' : '' }}>SSL (Porta 465)</option>
                    </select>
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">
                        TLS: Geralmente usa porta 587 (Gmail, Outlook, etc.)<br>
                        SSL: Geralmente usa porta 465 (servidores mais antigos)
                    </p>
                </div>
            </div>

            <!-- Porta -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="porta_email" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Porta
                </label>
                <div style="flex: 1;">
                    <input 
                        type="number" 
                        id="porta_email" 
                        name="porta_email" 
                        value="{{ old('porta_email', '587') }}"
                        class="form-input"
                        style="width: 100%; max-width: 400px;"
                    >
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Porta SMTP. 587 para TLS, 465 para SSL, 25 para sem criptografia (não recomendado).</p>
                </div>
            </div>

            <!-- Usuário -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="usuario_email" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Usuário
                </label>
                <div style="flex: 1;">
                    <input 
                        type="email" 
                        id="usuario_email" 
                        name="usuario_email" 
                        value="{{ old('usuario_email', 'seuemail@gmail.com') }}"
                        class="form-input"
                        style="width: 100%; max-width: 400px;"
                    >
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Informe nome de usuário do e-mail.</p>
                </div>
            </div>

            <!-- Senha -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="senha_email" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Senha
                </label>
                <div style="flex: 1;">
                    <input 
                        type="password" 
                        id="senha_email" 
                        name="senha_email" 
                        value="{{ old('senha_email') }}"
                        class="form-input"
                        style="width: 100%; max-width: 400px;"
                        placeholder="**********"
                    >
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Informe a senha do e-mail.</p>
                </div>
            </div>
        </div>

        <!-- Seção de Teste -->
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
            <h2 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.25rem; color: var(--text-primary);">Testar Configuração de E-mail</h2>
            
            <div style="display: grid; grid-template-columns: 180px 1fr auto; gap: 1.25rem; align-items: start;">
                <label for="email_teste" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Testar Configuração de E-mail
                </label>
                <div style="flex: 1; display: flex; gap: 0.75rem; align-items: flex-start;">
                    <input 
                        type="email" 
                        id="email_teste" 
                        name="email_teste" 
                        value="{{ old('email_teste', 'seuemail@exemplo.com') }}"
                        class="form-input"
                        style="width: 100%; max-width: 300px;"
                    >
                    <button type="button" onclick="enviarTeste()" class="btn" style="background: var(--success-color); color: white; white-space: nowrap;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Enviar Teste
                    </button>
                </div>
            </div>
            <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem; margin-left: calc(180px + 1.25rem);">Digite um e-mail para receber o teste</p>
        </div>

        <!-- Botão Salvar -->
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Salvar Alterações
            </button>
        </div>
    </form>
</div>

<script>
    function updatePorta() {
        const tipo = document.getElementById('tipo_criptografia').value;
        const porta = document.getElementById('porta_email');
        if (tipo === 'tls') {
            porta.value = '587';
        } else if (tipo === 'ssl') {
            porta.value = '465';
        }
    }

    function enviarTeste() {
        const email = document.getElementById('email_teste').value;
        if (!email) {
            alert('Por favor, informe um e-mail para teste.');
            return;
        }
        
        // Aqui você pode fazer uma requisição AJAX para enviar o teste
        alert('E-mail de teste será enviado para: ' + email);
    }
</script>
@endsection
