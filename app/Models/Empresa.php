<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'website',
        'logo_url',
        'plano',
        'status_pagamento',
    ];

    /**
     * Relacionamento com Users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relacionamento com Clientes
     */
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    /**
     * Relacionamento com Servicos
     */
    public function servicos()
    {
        return $this->hasMany(Servico::class);
    }

    /**
     * Relacionamento com LaudoTemplates
     */
    public function laudoTemplates()
    {
        return $this->hasMany(LaudoTemplate::class);
    }
}
