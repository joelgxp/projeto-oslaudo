<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Laudo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /**
     * Exibe relatório geral
     */
    public function index()
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id;

        // Estatísticas gerais
        $totalClientes = Cliente::where('empresa_id', $empresaId)->count();
        $totalServicos = Servico::where('empresa_id', $empresaId)->count();
        $totalLaudos = Laudo::whereHas('servico', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->count();
        $laudosAssinados = Laudo::whereHas('servico', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->where('assinado', true)->count();

        // Serviços por status
        $servicosPorStatus = Servico::where('empresa_id', $empresaId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Serviços por mês (últimos 6 meses)
        $servicosPorMes = Servico::where('empresa_id', $empresaId)
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'), DB::raw('count(*) as total'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Top 5 clientes (por número de serviços)
        $topClientes = Cliente::where('empresa_id', $empresaId)
            ->withCount('servicos')
            ->orderBy('servicos_count', 'desc')
            ->limit(5)
            ->get();

        return view('relatorios.index', compact(
            'totalClientes',
            'totalServicos',
            'totalLaudos',
            'laudosAssinados',
            'servicosPorStatus',
            'servicosPorMes',
            'topClientes'
        ));
    }

    /**
     * Relatório de clientes
     */
    public function clientes(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id;

        $query = Cliente::where('empresa_id', $empresaId)->withCount('servicos');

        // Filtros
        if ($request->filled('cidade')) {
            $query->where('cidade', $request->cidade);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $clientes = $query->orderBy('nome')->get();

        return view('relatorios.clientes', compact('clientes'));
    }

    /**
     * Relatório de serviços
     */
    public function servicos(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id;

        $query = Servico::where('empresa_id', $empresaId)
            ->with(['cliente', 'tecnico']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio')) {
            $query->where('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('created_at', '<=', $request->data_fim . ' 23:59:59');
        }

        $servicos = $query->orderBy('created_at', 'desc')->get();

        return view('relatorios.servicos', compact('servicos'));
    }

    /**
     * Relatório de laudos
     */
    public function laudos(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id;

        $query = Laudo::whereHas('servico', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->with(['servico.cliente', 'cliente']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('assinado')) {
            $query->where('assinado', $request->assinado === '1');
        }

        if ($request->filled('data_inicio')) {
            $query->where('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('created_at', '<=', $request->data_fim . ' 23:59:59');
        }

        $laudos = $query->orderBy('created_at', 'desc')->get();

        return view('relatorios.laudos', compact('laudos'));
    }
}
