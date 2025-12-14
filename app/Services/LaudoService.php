<?php

namespace App\Services;

use App\Models\Laudo;
use App\Models\Servico;
use App\Models\LaudoTemplate;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaudoService
{
    /**
     * Gera um laudo PDF a partir de um serviço
     */
    public function gerarLaudo(Servico $servico, ?LaudoTemplate $template = null): Laudo
    {
        // Verificar se o serviço está concluído
        if ($servico->status !== 'concluido') {
            throw new \Exception('O serviço precisa estar concluído para gerar o laudo.');
        }

        // Verificar se há execução
        if (!$servico->execucao) {
            throw new \Exception('O serviço precisa ter uma execução registrada para gerar o laudo.');
        }

        // Buscar template padrão se não fornecido
        if (!$template) {
            $template = LaudoTemplate::where('empresa_id', $servico->empresa_id)
                ->where(function($q) use ($servico) {
                    $q->where('tipo_servico', $servico->tipo_servico)
                      ->orWhereNull('tipo_servico');
                })
                ->where('ativo', true)
                ->first();
        }

        // Preparar dados para o template
        $dados = $this->prepararDados($servico);

        // Processar template HTML
        $html = $this->processarTemplate($template ? $template->conteudo_html : $this->getTemplatePadrao(), $dados);

        // Gerar PDF
        $pdfPath = $this->gerarPDF($html, $servico);

        // Criar registro do laudo
        $laudo = Laudo::create([
            'servico_id' => $servico->id,
            'cliente_id' => $servico->cliente_id,
            'template_id' => $template?->id,
            'conteudo_html' => $html,
            'arquivo_pdf' => $pdfPath,
            'status' => 'rascunho',
            'link_assinatura_unico' => Laudo::gerarLinkUnico(),
            'expira_em' => now()->addDays(30),
        ]);

        return $laudo;
    }

    /**
     * Prepara os dados do serviço para o template
     */
    private function prepararDados(Servico $servico): array
    {
        $cliente = $servico->cliente;
        $tecnico = $servico->tecnico;
        $execucao = $servico->execucao;

        return [
            'cliente_nome' => $cliente->nome,
            'cliente_email' => $cliente->email ?? '',
            'cliente_telefone' => $cliente->telefone ?? '',
            'cliente_endereco' => $this->formatarEndereco($cliente),
            'cliente_documento' => $cliente->tipo_documento && $cliente->numero_documento 
                ? strtoupper($cliente->tipo_documento) . ': ' . $cliente->numero_documento 
                : '',
            'servico_tipo' => $servico->tipo_servico,
            'servico_data' => $servico->data_execucao ? $servico->data_execucao->format('d/m/Y') : ($servico->data_agendada ? $servico->data_agendada->format('d/m/Y') : ''),
            'servico_descricao' => $servico->descricao_servico ?? '',
            'tecnico_nome' => $tecnico->name ?? '',
            'tecnico_email' => $tecnico->email ?? '',
            'problemas_encontrados' => $execucao->problemas_encontrados ?? '',
            'recomendacoes' => $execucao->recomendacoes ?? '',
            'data_emissao' => now()->format('d/m/Y'),
            'hora_emissao' => now()->format('H:i'),
        ];
    }

    /**
     * Formata o endereço completo do cliente
     */
    private function formatarEndereco($cliente): string
    {
        $endereco = [];
        
        if ($cliente->endereco) {
            $endereco[] = $cliente->endereco;
            if ($cliente->numero) {
                $endereco[] = $cliente->numero;
            }
            if ($cliente->complemento) {
                $endereco[] = $cliente->complemento;
            }
        }
        
        if ($cliente->cidade) {
            $cidade = $cliente->cidade;
            if ($cliente->estado) {
                $cidade .= '/' . $cliente->estado;
            }
            $endereco[] = $cidade;
        }
        
        if ($cliente->cep) {
            $endereco[] = 'CEP: ' . $cliente->cep;
        }
        
        return implode(', ', $endereco);
    }

    /**
     * Processa o template HTML substituindo variáveis
     */
    private function processarTemplate(string $template, array $dados): string
    {
        $html = $template;
        
        // Substituir variáveis {{variavel}}
        foreach ($dados as $key => $value) {
            $html = str_replace('{{' . $key . '}}', $value, $html);
            $html = str_replace('{{ ' . $key . ' }}', $value, $html);
        }
        
        return $html;
    }

    /**
     * Gera o arquivo PDF
     */
    private function gerarPDF(string $html, Servico $servico): string
    {
        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 16,
                'margin_bottom' => 16,
            ]);

            $mpdf->WriteHTML($html);
            
            // Gerar nome único para o arquivo
            $filename = 'laudos/' . Str::slug($servico->cliente->nome) . '_' . $servico->id . '_' . now()->format('YmdHis') . '.pdf';
            
            // Salvar no storage
            $pdfContent = $mpdf->Output('', 'S');
            Storage::disk('public')->put($filename, $pdfContent);
            
            return $filename;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao gerar PDF: ' . $e->getMessage());
        }
    }

    /**
     * Retorna template padrão caso não exista template específico
     */
    private function getTemplatePadrao(): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Laudo Técnico</title>
            <style>
                body { font-family: Arial, sans-serif; }
                h1 { color: #2563eb; text-align: center; }
                .header { text-align: center; margin-bottom: 30px; }
                .section { margin-bottom: 20px; }
                .label { font-weight: bold; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                table td { padding: 8px; border: 1px solid #ddd; }
                .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>LAUDO TÉCNICO</h1>
            </div>
            
            <div class="section">
                <h2>Dados do Cliente</h2>
                <p><span class="label">Nome:</span> {{cliente_nome}}</p>
                <p><span class="label">Email:</span> {{cliente_email}}</p>
                <p><span class="label">Telefone:</span> {{cliente_telefone}}</p>
                <p><span class="label">Endereço:</span> {{cliente_endereco}}</p>
                <p><span class="label">Documento:</span> {{cliente_documento}}</p>
            </div>
            
            <div class="section">
                <h2>Dados do Serviço</h2>
                <p><span class="label">Tipo de Serviço:</span> {{servico_tipo}}</p>
                <p><span class="label">Data:</span> {{servico_data}}</p>
                <p><span class="label">Descrição:</span> {{servico_descricao}}</p>
            </div>
            
            <div class="section">
                <h2>Execução do Serviço</h2>
                <p><span class="label">Técnico Responsável:</span> {{tecnico_nome}}</p>
                <p><span class="label">Problemas Encontrados:</span></p>
                <p>{{problemas_encontrados}}</p>
                <p><span class="label">Recomendações:</span></p>
                <p>{{recomendacoes}}</p>
            </div>
            
            <div class="footer">
                <p>Laudo gerado em {{data_emissao}} às {{hora_emissao}}</p>
            </div>
        </body>
        </html>
        ';
    }
}

