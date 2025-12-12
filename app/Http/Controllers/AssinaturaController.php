<?php

namespace App\Http\Controllers;

use App\Models\Laudo;
use App\Models\LaudoAssinatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AssinaturaController extends Controller
{
    /**
     * Mostra a página pública de assinatura
     */
    public function show(string $uuid)
    {
        $laudo = Laudo::where('link_assinatura_unico', $uuid)
            ->where('status', 'enviado')
            ->firstOrFail();

        // Verificar se o link expirou
        if ($laudo->expira_em && $laudo->expira_em->isPast()) {
            abort(410, 'Link de assinatura expirado.');
        }

        // Verificar se já foi assinado
        if ($laudo->assinado) {
            return view('laudos.assinado', compact('laudo'));
        }

        $laudo->load(['cliente', 'servico']);

        return view('laudos.assinador', compact('laudo'));
    }

    /**
     * Processa assinatura via canvas
     */
    public function assinarCanvas(Request $request, string $uuid)
    {
        $validated = $request->validate([
            'assinatura' => 'required|string',
        ]);

        $laudo = Laudo::where('link_assinatura_unico', $uuid)
            ->where('status', 'enviado')
            ->firstOrFail();

        // Verificar se o link expirou
        if ($laudo->expira_em && $laudo->expira_em->isPast()) {
            return back()->with('error', 'Link de assinatura expirado.');
        }

        // Verificar se já foi assinado
        if ($laudo->assinado) {
            return back()->with('error', 'Este laudo já foi assinado.');
        }

        // Salvar assinatura
        $laudo->update([
            'assinatura_cliente_base64' => $validated['assinatura'],
            'metodo_assinatura' => 'canvas',
            'data_assinatura_cliente' => now(),
            'assinado' => true,
            'status' => 'assinado',
        ]);

        // Registrar histórico
        LaudoAssinatura::create([
            'laudo_id' => $laudo->id,
            'cliente_id' => $laudo->cliente_id,
            'ip_cliente' => $request->ip(),
            'navegador' => $request->userAgent(),
            'dispositivo' => $this->detectarDispositivo($request),
            'metodo_assinatura' => 'canvas',
            'assinatura_base64' => $validated['assinatura'],
            'timestamp_assinatura' => now(),
            'hash_integridade' => Hash::make($validated['assinatura'] . $laudo->id),
        ]);

        return redirect()->route('assinatura.show', $uuid)
            ->with('success', 'Laudo assinado com sucesso!');
    }

    /**
     * Processa assinatura via biometria (WebAuthn)
     */
    public function assinarBiometria(Request $request, string $uuid)
    {
        $validated = $request->validate([
            'credential' => 'required|string',
        ]);

        $laudo = Laudo::where('link_assinatura_unico', $uuid)
            ->where('status', 'enviado')
            ->firstOrFail();

        // Verificar se o link expirou
        if ($laudo->expira_em && $laudo->expira_em->isPast()) {
            return back()->with('error', 'Link de assinatura expirado.');
        }

        // Verificar se já foi assinado
        if ($laudo->assinado) {
            return back()->with('error', 'Este laudo já foi assinado.');
        }

        // Aqui você implementaria a validação WebAuthn real
        // Por enquanto, vamos apenas salvar como assinado

        $laudo->update([
            'metodo_assinatura' => 'biometria',
            'data_assinatura_cliente' => now(),
            'assinado' => true,
            'status' => 'assinado',
        ]);

        // Registrar histórico
        LaudoAssinatura::create([
            'laudo_id' => $laudo->id,
            'cliente_id' => $laudo->cliente_id,
            'ip_cliente' => $request->ip(),
            'navegador' => $request->userAgent(),
            'dispositivo' => $this->detectarDispositivo($request),
            'metodo_assinatura' => 'biometria',
            'assinatura_base64' => $validated['credential'],
            'timestamp_assinatura' => now(),
            'hash_integridade' => Hash::make($validated['credential'] . $laudo->id),
        ]);

        return redirect()->route('assinatura.show', $uuid)
            ->with('success', 'Laudo assinado com sucesso via biometria!');
    }

    /**
     * Detecta o tipo de dispositivo
     */
    private function detectarDispositivo(Request $request): string
    {
        $userAgent = $request->userAgent();
        
        if (preg_match('/mobile|android|iphone|ipad/i', $userAgent)) {
            return 'mobile';
        }
        
        return 'desktop';
    }
}
