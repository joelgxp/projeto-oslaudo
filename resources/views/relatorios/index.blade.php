@extends('layouts.app')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 1.5rem; font-size: 2rem; font-weight: 700;">Relatórios Gerais</h1>

    <!-- Estatísticas Principais -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div style="background-color: #dbeafe; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #2563eb;">
            <h3 style="font-size: 0.875rem; color: #1e40af; margin-bottom: 0.5rem;">Total de Clientes</h3>
            <p style="font-size: 2rem; font-weight: 700; color: #1e40af;">{{ $totalClientes }}</p>
        </div>
        <div style="background-color: #fef3c7; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #f59e0b;">
            <h3 style="font-size: 0.875rem; color: #92400e; margin-bottom: 0.5rem;">Total de Serviços</h3>
            <p style="font-size: 2rem; font-weight: 700; color: #92400e;">{{ $totalServicos }}</p>
        </div>
        <div style="background-color: #e0e7ff; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #6366f1;">
            <h3 style="font-size: 0.875rem; color: #3730a3; margin-bottom: 0.5rem;">Laudos Gerados</h3>
            <p style="font-size: 2rem; font-weight: 700; color: #3730a3;">{{ $totalLaudos }}</p>
        </div>
        <div style="background-color: #d1fae5; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #10b981;">
            <h3 style="font-size: 0.875rem; color: #065f46; margin-bottom: 0.5rem;">Laudos Assinados</h3>
            <p style="font-size: 2rem; font-weight: 700; color: #065f46;">{{ $laudosAssinados }}</p>
            @if($totalLaudos > 0)
                <p style="font-size: 0.875rem; color: #065f46; margin-top: 0.5rem;">
                    {{ number_format(($laudosAssinados / $totalLaudos) * 100, 1) }}% do total
                </p>
            @endif
        </div>
    </div>

    <!-- Serviços por Status -->
    <div style="margin-bottom: 3rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Serviços por Status</h2>
        <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                @php
                    $statusLabels = [
                        'agendado' => 'Agendado',
                        'em_progresso' => 'Em Progresso',
                        'concluido' => 'Concluído',
                        'cancelado' => 'Cancelado'
                    ];
                    $statusColors = [
                        'agendado' => '#3b82f6',
                        'em_progresso' => '#f59e0b',
                        'concluido' => '#10b981',
                        'cancelado' => '#ef4444'
                    ];
                @endphp
                @foreach($statusLabels as $key => $label)
                    <div style="padding: 1rem; background-color: white; border-radius: 0.5rem; border-left: 4px solid {{ $statusColors[$key] ?? '#6b7280' }};">
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">{{ $label }}</p>
                        <p style="font-size: 1.5rem; font-weight: 700; color: {{ $statusColors[$key] ?? '#6b7280' }};">
                            {{ $servicosPorStatus[$key] ?? 0 }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top 5 Clientes -->
    @if($topClientes->count() > 0)
        <div style="margin-bottom: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Top 5 Clientes (por número de serviços)</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: white; border-bottom: 2px solid #e5e7eb;">
                                <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Cliente</th>
                                <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Total de Serviços</th>
                                <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topClientes as $cliente)
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 0.75rem;">{{ $cliente->nome }}</td>
                                    <td style="padding: 0.75rem;">
                                        <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #2563eb; color: white; font-size: 0.875rem;">
                                            {{ $cliente->servicos_count }}
                                        </span>
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ver Detalhes</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Links para Relatórios Detalhados -->
    <div style="margin-top: 3rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Relatórios Detalhados</h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('relatorios.clientes') }}" class="btn btn-primary">Relatório de Clientes</a>
            <a href="{{ route('relatorios.servicos') }}" class="btn btn-primary">Relatório de Serviços</a>
            <a href="{{ route('relatorios.laudos') }}" class="btn btn-primary">Relatório de Laudos</a>
        </div>
    </div>
</div>
@endsection

