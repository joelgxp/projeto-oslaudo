<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoExecucao extends Model
{
    use HasFactory;

    protected $fillable = [
        'servico_id',
        'checklist_preenchido',
        'fotos',
        'problemas_encontrados',
        'recomendacoes',
        'assinatura_tecnico',
        'data_assinatura',
        'status',
    ];

    protected $casts = [
        'checklist_preenchido' => 'array',
        'fotos' => 'array',
        'data_assinatura' => 'datetime',
    ];

    /**
     * Relacionamento com Servico
     */
    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}
