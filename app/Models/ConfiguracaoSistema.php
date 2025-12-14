<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracaoSistema extends Model
{
    use HasFactory;

    /**
     * Nome da tabela no banco de dados
     */
    protected $table = 'configuracoes_sistema';

    protected $fillable = [
        'empresa_id',
        'chave',
        'valor',
        'tipo',
        'descricao',
    ];

    /**
     * Obter valor de uma configuração
     */
    public static function get($chave, $empresaId, $default = null)
    {
        $config = self::where('empresa_id', $empresaId)
            ->where('chave', $chave)
            ->first();

        if (!$config) {
            return $default;
        }

        return match($config->tipo) {
            'boolean' => (bool) $config->valor,
            'integer' => (int) $config->valor,
            'json' => json_decode($config->valor, true),
            default => $config->valor,
        };
    }

    /**
     * Definir valor de uma configuração
     */
    public static function set($chave, $valor, $empresaId, $tipo = 'string', $descricao = null)
    {
        $config = self::where('empresa_id', $empresaId)
            ->where('chave', $chave)
            ->first();

        $valorFormatado = match($tipo) {
            'boolean' => $valor ? '1' : '0',
            'integer' => (string) $valor,
            'json' => json_encode($valor),
            default => (string) $valor,
        };

        if ($config) {
            $config->update([
                'valor' => $valorFormatado,
                'tipo' => $tipo,
                'descricao' => $descricao ?? $config->descricao,
            ]);
        } else {
            self::create([
                'empresa_id' => $empresaId,
                'chave' => $chave,
                'valor' => $valorFormatado,
                'tipo' => $tipo,
                'descricao' => $descricao,
            ]);
        }
    }
}
