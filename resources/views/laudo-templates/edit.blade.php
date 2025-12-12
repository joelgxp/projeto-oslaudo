@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Editar Template de Laudo</h1>
        <a href="{{ route('laudo-templates.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <form method="POST" action="{{ route('laudo-templates.update', $laudoTemplate) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nome do Template *</label>
                <input type="text" name="nome_template" class="form-input" value="{{ old('nome_template', $laudoTemplate->nome_template) }}" required>
                @error('nome_template')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de Serviço *</label>
                <input type="text" name="tipo_servico" class="form-input" value="{{ old('tipo_servico', $laudoTemplate->tipo_servico) }}" required>
                @error('tipo_servico')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Conteúdo HTML do Template *</label>
                <textarea name="conteudo_html" class="form-input" rows="20" required style="font-family: monospace;">{{ old('conteudo_html', $laudoTemplate->conteudo_html) }}</textarea>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">
                    Use variáveis como {{cliente_nome}}, {{servico_tipo}}, etc. para preencher automaticamente.
                </p>
                @error('conteudo_html')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="ativo" value="1" {{ old('ativo', $laudoTemplate->ativo) ? 'checked' : '' }} class="form-checkbox">
                    <span>Template Ativo</span>
                </label>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Atualizar Template</button>
            <a href="{{ route('laudo-templates.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

