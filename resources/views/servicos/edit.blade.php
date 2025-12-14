@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Editar Ordem de Serviço</h1>
        <a href="{{ route('servicos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <form method="POST" action="{{ route('servicos.update', $servico) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">Cliente *</label>
                <select name="cliente_id" class="form-input" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id', $servico->cliente_id) == $cliente->id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Técnico</label>
                <select name="tecnico_id" class="form-input">
                    <option value="">Selecione um técnico</option>
                    @forelse($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}" {{ old('tecnico_id', $servico->tecnico_id) == $tecnico->id ? 'selected' : '' }}>{{ $tecnico->name }}</option>
                    @empty
                        <option value="" disabled>Nenhum técnico cadastrado</option>
                    @endforelse
                </select>
                @if($tecnicos->count() === 0)
                    <p style="font-size: 0.875rem; color: #f59e0b; margin-top: 0.5rem;">
                        ⚠️ Nenhum técnico cadastrado. <a href="{{ route('configuracoes.usuarios') }}" style="color: #2563eb; text-decoration: underline;">Cadastre um técnico aqui</a>
                    </p>
                @endif
                @error('tecnico_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de Serviço *</label>
                <input type="text" name="tipo_servico" class="form-input" value="{{ old('tipo_servico', $servico->tipo_servico) }}" required>
                @error('tipo_servico')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Data Agendada</label>
                <input type="date" name="data_agendada" class="form-input" value="{{ old('data_agendada', $servico->data_agendada?->format('Y-m-d')) }}">
                @error('data_agendada')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Hora de Início</label>
                <input type="time" name="hora_inicio" class="form-input" value="{{ old('hora_inicio', $servico->hora_inicio?->format('H:i')) }}">
                @error('hora_inicio')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label">Endereço do Serviço</label>
                <input type="text" name="endereco_servico" class="form-input" value="{{ old('endereco_servico', $servico->endereco_servico) }}">
                @error('endereco_servico')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label">Descrição do Serviço</label>
                <textarea name="descricao_servico" class="form-input" rows="3">{{ old('descricao_servico', $servico->descricao_servico) }}</textarea>
                @error('descricao_servico')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label">Observações</label>
                <textarea name="observacoes" class="form-input" rows="3">{{ old('observacoes', $servico->observacoes) }}</textarea>
                @error('observacoes')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status *</label>
                <select name="status" class="form-input" required>
                    <option value="agendado" {{ old('status', $servico->status) === 'agendado' ? 'selected' : '' }}>Agendado</option>
                    <option value="em_progresso" {{ old('status', $servico->status) === 'em_progresso' ? 'selected' : '' }}>Em Progresso</option>
                    <option value="concluido" {{ old('status', $servico->status) === 'concluido' ? 'selected' : '' }}>Concluído</option>
                    <option value="cancelado" {{ old('status', $servico->status) === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('status')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Atualizar OS</button>
            <a href="{{ route('servicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

