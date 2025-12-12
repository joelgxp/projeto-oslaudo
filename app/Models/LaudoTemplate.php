<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaudoTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'tipo_servico',
        'nome_template',
        'conteudo_html',
        'campos_obrigatorios',
        'campos_opcionais',
        'criado_por',
        'ativo',
    ];

    protected $casts = [
        'campos_obrigatorios' => 'array',
        'campos_opcionais' => 'array',
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamento com Empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relacionamento com User (criador)
     */
    public function criador()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    /**
     * Relacionamento com Laudos
     */
    public function laudos()
    {
        return $this->hasMany(Laudo::class, 'template_id');
    }
}
