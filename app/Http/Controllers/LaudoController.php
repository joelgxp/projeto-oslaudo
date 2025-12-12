<?php

namespace App\Http\Controllers;

use App\Models\Laudo;
use App\Models\Servico;
use App\Services\LaudoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaudoController extends Controller
{
    protected $laudoService;

    public function __construct(LaudoService $laudoService)
    {
        $this->laudoService = $laudoService;
    }

    /**
     * Gera um laudo a partir de um serviço
     */
    public function gerar(Servico $servico)
    {
        $user = Auth::user();
        
        // Verificar se o serviço pertence à empresa
        if ($servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        // Verificar se o serviço está concluído
        if ($servico->status !== 'concluido') {
            return back()->with('error', 'O serviço precisa estar concluído para gerar o laudo.');
        }

        try {
            $laudo = $this->laudoService->gerarLaudo($servico);
            
            return redirect()->route('servicos.show', $servico)
                ->with('success', 'Laudo gerado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao gerar laudo: ' . $e->getMessage());
        }
    }

    /**
     * Visualiza o laudo
     */
    public function show(Laudo $laudo)
    {
        $user = Auth::user();
        
        // Verificar se o laudo pertence à empresa
        if ($laudo->servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $laudo->load(['servico.cliente', 'servico.tecnico', 'template']);

        return view('laudos.show', compact('laudo'));
    }

    /**
     * Baixa o PDF do laudo
     */
    public function download(Laudo $laudo)
    {
        $user = Auth::user();
        
        // Verificar se o laudo pertence à empresa
        if ($laudo->servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        if (!$laudo->arquivo_pdf || !Storage::disk('public')->exists($laudo->arquivo_pdf)) {
            abort(404, 'Arquivo PDF não encontrado.');
        }

        return Storage::disk('public')->download($laudo->arquivo_pdf);
    }

    /**
     * Envia laudo para assinatura
     */
    public function enviarAssinatura(Laudo $laudo)
    {
        $user = Auth::user();
        
        // Verificar se o laudo pertence à empresa
        if ($laudo->servico->empresa_id !== $user->empresa_id) {
            abort(403);
        }

        $laudo->update([
            'status' => 'enviado',
            'link_assinatura_unico' => Laudo::gerarLinkUnico(),
            'expira_em' => now()->addDays(30),
        ]);

        // Aqui você pode enviar email para o cliente com o link de assinatura
        // Mail::to($laudo->cliente->email)->send(new LaudoAssinaturaMail($laudo));

        return back()->with('success', 'Laudo enviado para assinatura com sucesso!');
    }
}
