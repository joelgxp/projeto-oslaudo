@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Novo Template de Laudo</h1>
        <a href="{{ route('laudo-templates.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <form method="POST" action="{{ route('laudo-templates.store') }}">
        @csrf

        <div style="display: grid; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Nome do Template *</label>
                <input type="text" name="nome_template" class="form-input" value="{{ old('nome_template') }}" placeholder="Ex: Template Dedetização" required>
                @error('nome_template')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de Serviço *</label>
                <input type="text" name="tipo_servico" class="form-input" value="{{ old('tipo_servico') }}" placeholder="Ex: Dedetização" required>
                @error('tipo_servico')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Conteúdo HTML do Template *</label>
                <textarea name="conteudo_html" class="form-input" rows="20" required style="font-family: monospace;">@if(old('conteudo_html')){{ old('conteudo_html') }}@else<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laudo Técnico</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2563eb; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table td { padding: 8px; border: 1px solid #ddd; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAUDO TÉCNICO</h1>
    </div>
    
    <div class="section">
        <h2>Dados do Cliente</h2>
        <p><span class="label">Nome:</span> {!! "{{" !!}cliente_nome{!! "}}" !!}</p>
        <p><span class="label">Email:</span> {!! "{{" !!}cliente_email{!! "}}" !!}</p>
        <p><span class="label">Telefone:</span> {!! "{{" !!}cliente_telefone{!! "}}" !!}</p>
        <p><span class="label">Endereço:</span> {!! "{{" !!}cliente_endereco{!! "}}" !!}</p>
        <p><span class="label">Documento:</span> {!! "{{" !!}cliente_documento{!! "}}" !!}</p>
    </div>
    
    <div class="section">
        <h2>Dados do Serviço</h2>
        <p><span class="label">Tipo de Serviço:</span> {!! "{{" !!}servico_tipo{!! "}}" !!}</p>
        <p><span class="label">Data:</span> {!! "{{" !!}servico_data{!! "}}" !!}</p>
        <p><span class="label">Descrição:</span> {!! "{{" !!}servico_descricao{!! "}}" !!}</p>
    </div>
    
    <div class="section">
        <h2>Execução do Serviço</h2>
        <p><span class="label">Técnico Responsável:</span> {!! "{{" !!}tecnico_nome{!! "}}" !!}</p>
        <p><span class="label">Problemas Encontrados:</span></p>
        <p>{!! "{{" !!}problemas_encontrados{!! "}}" !!}</p>
        <p><span class="label">Recomendações:</span></p>
        <p>{!! "{{" !!}recomendacoes{!! "}}" !!}</p>
    </div>
    
    <div class="footer">
        <p>Laudo gerado em {!! "{{" !!}data_emissao{!! "}}" !!} às {!! "{{" !!}hora_emissao{!! "}}" !!}</p>
    </div>
</body>
</html>@endif</textarea>
                <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">
                    Use variáveis como {{cliente_nome}}, {{servico_tipo}}, etc. para preencher automaticamente.
                </p>
                @error('conteudo_html')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Salvar Template</button>
            <a href="{{ route('laudo-templates.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

