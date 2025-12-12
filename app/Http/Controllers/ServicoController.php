<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id;

        $query = Servico::where('empresa_id', $empresaId)->with(['cliente', 'tecnico']);

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por técnico (apenas para admin)
        if ($request->filled('tecnico_id') && $user->isAdmin()) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        // Para técnicos, mostrar apenas seus serviços
        if ($user->isTechnician()) {
            $query->where('tecnico_id', $user->id);
        }

        // Busca por nome do cliente
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%");
            });
        }

        $servicos = $query->orderBy('data_agendada', 'desc')->paginate(15);

        $tecnicos = User::where('empresa_id', $empresaId)
            ->where('role', 'technician')
            ->get();

        return view('servicos.index', compact('servicos', 'tecnicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $clientes = Cliente::where('empresa_id', $user->empresa_id)->orderBy('nome')->get();
        $tecnicos = User::where('empresa_id', $user->empresa_id)
            ->where('role', 'technician')
            ->get();

        return view('servicos.create', compact('clientes', 'tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'tipo_servico' => 'required|string|max:255',
            'data_agendada' => 'nullable|date',
            'hora_inicio' => 'nullable',
            'endereco_servico' => 'nullable|string',
            'descricao_servico' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:agendado,em_progresso,concluido,cancelado',
        ]);

        // Verificar se o cliente pertence à empresa
        $cliente = Cliente::findOrFail($validated['cliente_id']);
        if ($cliente->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $validated['empresa_id'] = $user->empresa_id;

        Servico::create($validated);

        return redirect()->route('servicos.index')
            ->with('success', 'Ordem de Serviço criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        // Verificar se técnico pode ver apenas seus serviços
        if ($user->isTechnician() && $servico->tecnico_id !== $user->id) {
            abort(403);
        }

        $servico->load(['cliente', 'tecnico', 'execucao', 'laudos']);

        return view('servicos.show', compact('servico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $clientes = Cliente::where('empresa_id', $user->empresa_id)->orderBy('nome')->get();
        $tecnicos = User::where('empresa_id', $user->empresa_id)
            ->where('role', 'technician')
            ->get();

        return view('servicos.edit', compact('servico', 'clientes', 'tecnicos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'tipo_servico' => 'required|string|max:255',
            'data_agendada' => 'nullable|date',
            'hora_inicio' => 'nullable',
            'endereco_servico' => 'nullable|string',
            'descricao_servico' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:agendado,em_progresso,concluido,cancelado',
        ]);

        // Verificar se o cliente pertence à empresa
        $cliente = Cliente::findOrFail($validated['cliente_id']);
        if ($cliente->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $servico->update($validated);

        return redirect()->route('servicos.index')
            ->with('success', 'Ordem de Serviço atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        // Verificar se há laudos vinculados
        if ($servico->laudos()->count() > 0) {
            return redirect()->route('servicos.index')
                ->with('error', 'Não é possível excluir serviço com laudos vinculados.');
        }

        $servico->delete();

        return redirect()->route('servicos.index')
            ->with('success', 'Ordem de Serviço excluída com sucesso!');
    }

    /**
     * Mostra a página de execução do serviço (para técnicos)
     */
    public function executar(Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa e ao técnico
        if ($servico->empresa_id !== $user->empresa_id || $servico->tecnico_id !== $user->id) {
            abort(403);
        }

        $servico->load(['cliente', 'execucao']);

        return view('servicos.executar', compact('servico'));
    }

    /**
     * Salva a execução do serviço
     */
    public function salvarExecucao(Request $request, Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa e ao técnico
        if ($servico->empresa_id !== $user->empresa_id || $servico->tecnico_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'checklist_preenchido' => 'nullable|array',
            'fotos' => 'nullable|array',
            'problemas_encontrados' => 'nullable|string',
            'recomendacoes' => 'nullable|string',
            'assinatura_tecnico' => 'nullable|string',
        ]);

        // Processar fotos (upload)
        if ($request->hasFile('fotos')) {
            $fotosUrls = [];
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('fotos', 'public');
                $fotosUrls[] = $path;
            }
            $validated['fotos'] = $fotosUrls;
        }

        // Criar ou atualizar execução
        $execucao = $servico->execucao ?? new \App\Models\ServicoExecucao();
        $execucao->servico_id = $servico->id;
        $execucao->fill($validated);
        
        if ($request->filled('assinatura_tecnico')) {
            $execucao->data_assinatura = now();
            $execucao->status = 'assinado';
        }
        
        $execucao->save();

        // Atualizar status do serviço
        $servico->update([
            'status' => 'concluido',
            'data_execucao' => now(),
        ]);

        return redirect()->route('servicos.show', $servico)
            ->with('success', 'Execução do serviço salva com sucesso!');
    }
}
