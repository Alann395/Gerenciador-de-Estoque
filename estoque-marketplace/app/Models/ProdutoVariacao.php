<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoVariacao extends Model
{
    protected $table = 'produto_variacoes';

    protected $fillable = [
        'produto_id',
        'cor',
        'tamanho',
        'sku',
        'estoque',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
