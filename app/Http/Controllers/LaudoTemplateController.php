<?php

namespace App\Http\Controllers;

use App\Models\LaudoTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaudoTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $templates = LaudoTemplate::where('empresa_id', $user->empresa_id)
            ->orderBy('tipo_servico')
            ->orderBy('nome_template')
            ->get();

        return view('laudo-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laudo-templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'tipo_servico' => 'required|string|max:255',
            'nome_template' => 'required|string|max:255',
            'conteudo_html' => 'required|string',
            'campos_obrigatorios' => 'nullable|array',
            'campos_opcionais' => 'nullable|array',
        ]);

        $validated['empresa_id'] = $user->empresa_id;
        $validated['criado_por'] = $user->id;
        $validated['ativo'] = true;

        LaudoTemplate::create($validated);

        return redirect()->route('laudo-templates.index')
            ->with('success', 'Template criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LaudoTemplate $laudoTemplate)
    {
        $user = Auth::user();
        
        if ($laudoTemplate->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        return view('laudo-templates.show', compact('laudoTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaudoTemplate $laudoTemplate)
    {
        $user = Auth::user();
        
        if ($laudoTemplate->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        return view('laudo-templates.edit', compact('laudoTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaudoTemplate $laudoTemplate)
    {
        $user = Auth::user();
        
        if ($laudoTemplate->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $validated = $request->validate([
            'tipo_servico' => 'required|string|max:255',
            'nome_template' => 'required|string|max:255',
            'conteudo_html' => 'required|string',
            'campos_obrigatorios' => 'nullable|array',
            'campos_opcionais' => 'nullable|array',
            'ativo' => 'boolean',
        ]);

        $laudoTemplate->update($validated);

        return redirect()->route('laudo-templates.index')
            ->with('success', 'Template atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaudoTemplate $laudoTemplate)
    {
        $user = Auth::user();
        
        if ($laudoTemplate->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        // Verificar se há laudos usando este template
        if ($laudoTemplate->laudos()->count() > 0) {
            return redirect()->route('laudo-templates.index')
                ->with('error', 'Não é possível excluir template com laudos vinculados.');
        }

        $laudoTemplate->delete();

        return redirect()->route('laudo-templates.index')
            ->with('success', 'Template excluído com sucesso!');
    }
}
