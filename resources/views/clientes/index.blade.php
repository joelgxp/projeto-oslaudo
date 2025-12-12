@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo Cliente</a>
    </div>

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtros e Busca -->
    <form method="GET" action="{{ route('clientes.index') }}" style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Buscar</label>
                <input type="text" name="search" class="form-input" placeholder="Nome, email, telefone ou documento" value="{{ request('search') }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Cidade</label>
                <input type="text" name="cidade" class="form-input" placeholder="Cidade" value="{{ request('cidade') }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Estado</label>
                <input type="text" name="estado" class="form-input" placeholder="UF" maxlength="2" value="{{ request('estado') }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Tipo Documento</label>
                <select name="tipo_documento" class="form-input">
                    <option value="">Todos</option>
                    <option value="cpf" {{ request('tipo_documento') === 'cpf' ? 'selected' : '' }}>CPF</option>
                    <option value="cnpj" {{ request('tipo_documento') === 'cnpj' ? 'selected' : '' }}>CNPJ</option>
                </select>
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <!-- Tabela de Clientes -->
    @if($clientes->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Nome</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Email</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Telefone</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Cidade/UF</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Documento</th>
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
                            <td style="padding: 0.75rem;">
                                @if($cliente->tipo_documento && $cliente->numero_documento)
                                    {{ strtoupper($cliente->tipo_documento) }}: {{ $cliente->numero_documento }}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ver</a>
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Editar</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div style="margin-top: 2rem;">
            {{ $clientes->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p style="font-size: 1.125rem;">Nenhum cliente encontrado.</p>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary" style="margin-top: 1rem;">Cadastrar Primeiro Cliente</a>
        </div>
    @endif
</div>
@endsection

