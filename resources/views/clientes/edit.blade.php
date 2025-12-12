@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Editar Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <form method="POST" action="{{ route('clientes.update', $cliente) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nome *</label>
                <input type="text" name="nome" class="form-input" value="{{ old('nome', $cliente->nome) }}" required>
                @error('nome')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $cliente->email) }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-input" value="{{ old('telefone', $cliente->telefone) }}" placeholder="(00) 00000-0000">
                @error('telefone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de Documento</label>
                <select name="tipo_documento" class="form-input" id="tipo_documento">
                    <option value="">Selecione</option>
                    <option value="cpf" {{ old('tipo_documento', $cliente->tipo_documento) === 'cpf' ? 'selected' : '' }}>CPF</option>
                    <option value="cnpj" {{ old('tipo_documento', $cliente->tipo_documento) === 'cnpj' ? 'selected' : '' }}>CNPJ</option>
                </select>
                @error('tipo_documento')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Número do Documento</label>
                <input type="text" name="numero_documento" class="form-input" value="{{ old('numero_documento', $cliente->numero_documento) }}" id="numero_documento" placeholder="000.000.000-00 ou 00.000.000/0000-00">
                @error('numero_documento')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">CEP</label>
                <input type="text" name="cep" class="form-input" value="{{ old('cep', $cliente->cep) }}" placeholder="00000-000">
                @error('cep')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Endereço</label>
                <input type="text" name="endereco" class="form-input" value="{{ old('endereco', $cliente->endereco) }}">
                @error('endereco')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Número</label>
                <input type="text" name="numero" class="form-input" value="{{ old('numero', $cliente->numero) }}">
                @error('numero')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Complemento</label>
                <input type="text" name="complemento" class="form-input" value="{{ old('complemento', $cliente->complemento) }}">
                @error('complemento')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Cidade</label>
                <input type="text" name="cidade" class="form-input" value="{{ old('cidade', $cliente->cidade) }}">
                @error('cidade')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Estado (UF)</label>
                <input type="text" name="estado" class="form-input" value="{{ old('estado', $cliente->estado) }}" maxlength="2" placeholder="SP">
                @error('estado')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Atualizar Cliente</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

