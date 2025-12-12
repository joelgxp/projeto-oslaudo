@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Relatório de Clientes</h1>
        <a href="{{ route('relatorios.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('relatorios.clientes') }}" style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Cidade</label>
                <input type="text" name="cidade" class="form-input" value="{{ request('cidade') }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Estado</label>
                <input type="text" name="estado" class="form-input" value="{{ request('estado') }}" maxlength="2">
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('relatorios.clientes') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <!-- Tabela de Clientes -->
    @if($clientes->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Cliente</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Email</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Telefone</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Cidade/UF</th>
                        <th style="padding: 0.75rem; text-align: center; font-weight: 600;">Total de Serviços</th>
                        <th style="padding: 0.75rem; text-align: center; font-weight: 600;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem;">{{ $cliente->nome }}</td>
                            <td style="padding: 0.75rem;">{{ $cliente->email ?? '-' }}</td>
                            <td style="padding: 0.75rem;">{{ $cliente->telefone ?? '-' }}</td>
                            <td style="padding: 0.75rem;">{{ $cliente->cidade ?? '-' }}{{ $cliente->estado ? '/' . $cliente->estado : '' }}</td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #2563eb; color: white; font-size: 0.875rem;">
                                    {{ $cliente->servicos_count }}
                                </span>
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem; padding: 1rem; background-color: #f9fafb; border-radius: 0.5rem;">
            <p><strong>Total de Clientes:</strong> {{ $clientes->count() }}</p>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p style="font-size: 1.125rem;">Nenhum cliente encontrado com os filtros aplicados.</p>
        </div>
    @endif
</div>
@endsection

