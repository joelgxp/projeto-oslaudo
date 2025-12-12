@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Templates de Laudos</h1>
        <a href="{{ route('laudo-templates.create') }}" class="btn btn-primary">Novo Template</a>
    </div>

    @if($templates->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Nome</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Tipo de Serviço</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Status</th>
                        <th style="padding: 0.75rem; text-align: center; font-weight: 600;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($templates as $template)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem;">{{ $template->nome_template }}</td>
                            <td style="padding: 0.75rem;">{{ $template->tipo_servico }}</td>
                            <td style="padding: 0.75rem;">
                                @if($template->ativo)
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #10b981; color: white; font-size: 0.875rem;">Ativo</span>
                                @else
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #6b7280; color: white; font-size: 0.875rem;">Inativo</span>
                                @endif
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('laudo-templates.show', $template) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ver</a>
                                    <a href="{{ route('laudo-templates.edit', $template) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Editar</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p style="font-size: 1.125rem;">Nenhum template cadastrado.</p>
            <a href="{{ route('laudo-templates.create') }}" class="btn btn-primary" style="margin-top: 1rem;">Criar Primeiro Template</a>
        </div>
    @endif
</div>
@endsection

