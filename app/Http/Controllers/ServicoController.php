<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Cliente;
use App\Models\User;
use App\Http\Requests\ServicoRequest;
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
    public function store(ServicoRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();
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
    public function update(ServicoRequest $request, Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $validated = $request->validated();
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
                ->with('error', 'Não é possível excluir serviço com laudos vinculados. Exclua os laudos primeiro.');
        }

        // Verificar se há execução vinculada
        if ($servico->execucao) {
            $servico->execucao->delete();
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
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        // Verificar se é técnico e se o serviço é dele, ou se é admin
        if ($user->isTechnician() && $servico->tecnico_id !== $user->id) {
            abort(403, 'Você só pode executar serviços atribuídos a você.');
        }

        // Permitir que admin também possa executar (para testes/correções)
        if (!$user->isAdmin() && !$user->isTechnician()) {
            abort(403);
        }

        $servico->load(['cliente', 'execucao', 'tecnico']);

        return view('servicos.executar', compact('servico'));
    }

    /**
     * Salva a execução do serviço
     */
    public function salvarExecucao(Request $request, Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        // Verificar se é técnico e se o serviço é dele, ou se é admin
        if ($user->isTechnician() && $servico->tecnico_id !== $user->id) {
            abort(403, 'Você só pode executar serviços atribuídos a você.');
        }

        // Permitir que admin também possa salvar execução
        if (!$user->isAdmin() && !$user->isTechnician()) {
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
