<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    use HasFactory;

    // nome REAL da tabela
    protected $table = 'movimentacoes';

    protected $fillable = [
        'produto_variacao_id',
        'tipo',
        'quantidade',
        'motivo',
    ];

    public function variacao()
    {
        return $this->belongsTo(ProdutoVariacao::class, 'produto_variacao_id');
    }
}
