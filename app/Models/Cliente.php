<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nome',
        'email',
        'telefone',
        'endereco',
        'numero',
        'complemento',
        'cidade',
        'estado',
        'cep',
        'tipo_documento',
        'numero_documento',
        'data_criacao',
    ];

    protected $casts = [
        'data_criacao' => 'date',
    ];

    /**
     * Relacionamento com Empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relacionamento com Servicos
     */
    public function servicos()
    {
        return $this->hasMany(Servico::class);
    }

    /**
     * Relacionamento com Laudos
     */
    public function laudos()
    {
        return $this->hasMany(Laudo::class);
    }

    /**
     * Relacionamento com LaudoAssinaturas
     */
    public function assinaturas()
    {
        return $this->hasMany(LaudoAssinatura::class);
    }
}
