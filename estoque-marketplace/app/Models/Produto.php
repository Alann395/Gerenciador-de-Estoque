<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProdutoVariacao;

class Produto extends Model
{
    protected $fillable = [
        'cliente_id',
        'sku_interno',
        'nome',
        'codigo_barras',
        'peso',
        'altura',
        'largura',
        'comprimento',
        'ativo'
    ];
    public function variacoes()
    {
    return $this->hasMany(ProdutoVariacao::class, 'produto_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function saldos()
    {
        return $this->hasMany(SaldoEstoque::class);
    }
    public function estoqueTotal()
    {
        return $this->variacoes->sum('estoque');
    }


} 

