<?php

namespace App\Http\Controllers;

use App\Models\Laudo;
use App\Models\Servico;
use App\Services\LaudoService;
use App\Notifications\LaudoEnviadoNotification;
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
    public function gerar(Request $request, Servico $servico)
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
            // Buscar template se especificado
            $template = null;
            if ($request->filled('template_id')) {
                $template = \App\Models\LaudoTemplate::where('id', $request->template_id)
                    ->where('empresa_id', $user->empresa_id)
                    ->where('ativo', true)
                    ->first();
            }

            $laudo = $this->laudoService->gerarLaudo($servico, $template);
            
            return redirect()->route('servicos.show', $servico)
                ->with('success', 'Laudo gerado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar laudo: ' . $e->getMessage(), [
                'servico_id' => $servico->id,
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Erro ao gerar laudo. Verifique se o serviço está concluído e tem execução registrada.');
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
            \Log::error('PDF não encontrado', [
                'laudo_id' => $laudo->id,
                'arquivo_pdf' => $laudo->arquivo_pdf
            ]);
            return back()->with('error', 'Arquivo PDF não encontrado. Por favor, gere o laudo novamente.');
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

        // Notificar cliente (se tiver email e usuário cadastrado)
        if ($laudo->cliente->email) {
            // Aqui você pode enviar email para o cliente com o link de assinatura
            // Mail::to($laudo->cliente->email)->send(new LaudoAssinaturaMail($laudo));
        }

        // Notificar admin da empresa
        $empresa = Auth::user()->empresa;
        if ($empresa) {
            $admins = $empresa->users()->where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new LaudoEnviadoNotification($laudo));
            }
        }

        return back()->with('success', 'Laudo enviado para assinatura com sucesso!');
    }
}
