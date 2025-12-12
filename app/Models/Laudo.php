<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laudo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'servico_id',
        'cliente_id',
        'template_id',
        'conteudo_html',
        'arquivo_pdf',
        'assinado',
        'data_assinatura_cliente',
        'assinatura_cliente_base64',
        'metodo_assinatura',
        'status',
        'link_assinatura_unico',
        'expira_em',
    ];

    protected $casts = [
        'assinado' => 'boolean',
        'data_assinatura_cliente' => 'datetime',
        'expira_em' => 'datetime',
    ];

    /**
     * Relacionamento com Servico
     */
    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }

    /**
     * Relacionamento com Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento com LaudoTemplate
     */
    public function template()
    {
        return $this->belongsTo(LaudoTemplate::class, 'template_id');
    }

    /**
     * Relacionamento com LaudoAssinaturas
     */
    public function assinaturas()
    {
        return $this->hasMany(LaudoAssinatura::class);
    }

    /**
     * Gerar UUID único para link de assinatura
     */
    public static function gerarLinkUnico(): string
    {
        return \Illuminate\Support\Str::uuid()->toString();
    }
}
