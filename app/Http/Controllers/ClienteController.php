<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id;

        $query = Cliente::where('empresa_id', $empresaId);

        // Busca por nome, email, telefone ou documento
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%")
                  ->orWhere('numero_documento', 'like', "%{$search}%");
            });
        }

        // Filtro por cidade
        if ($request->filled('cidade')) {
            $query->where('cidade', $request->cidade);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por tipo de documento
        if ($request->filled('tipo_documento')) {
            $query->where('tipo_documento', $request->tipo_documento);
        }

        $clientes = $query->orderBy('nome')->paginate(15);

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();
        $validated['empresa_id'] = $user->empresa_id;
        $validated['data_criacao'] = now();

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $user = Auth::user();
        
        // Verificar se o cliente pertence à empresa do usuário
        if ($cliente->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $cliente->load('servicos');

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $user = Auth::user();
        
        // Verificar se o cliente pertence à empresa do usuário
        if ($cliente->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $user = Auth::user();
        
        // Verificar se o cliente pertence à empresa do usuário
        if ($cliente->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $validated = $request->validated();
        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $user = Auth::user();
        
        // Verificar se o cliente pertence à empresa do usuário
        if ($cliente->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        // Verificar se há serviços vinculados
        if ($cliente->servicos()->count() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', 'Não é possível excluir cliente com serviços vinculados.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
