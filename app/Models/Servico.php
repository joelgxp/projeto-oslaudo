<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'tecnico_id',
        'tipo_servico',
        'data_agendada',
        'data_execucao',
        'hora_inicio',
        'hora_fim',
        'endereco_servico',
        'descricao_servico',
        'observacoes',
        'status',
    ];

    protected $casts = [
        'data_agendada' => 'date',
        'data_execucao' => 'date',
        'hora_inicio' => 'datetime',
        'hora_fim' => 'datetime',
    ];

    /**
     * Relacionamento com Empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relacionamento com Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento com Técnico (User)
     */
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    /**
     * Relacionamento com ServicoExecucao
     */
    public function execucao()
    {
        return $this->hasOne(ServicoExecucao::class);
    }

    /**
     * Relacionamento com Laudos
     */
    public function laudos()
    {
        return $this->hasMany(Laudo::class);
    }
}
