<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaudoAssinatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'laudo_id',
        'cliente_id',
        'ip_cliente',
        'navegador',
        'dispositivo',
        'metodo_assinatura',
        'assinatura_base64',
        'timestamp_assinatura',
        'hash_integridade',
    ];

    protected $casts = [
        'timestamp_assinatura' => 'datetime',
    ];

    /**
     * Relacionamento com Laudo
     */
    public function laudo()
    {
        return $this->belongsTo(Laudo::class);
    }

    /**
     * Relacionamento com Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
