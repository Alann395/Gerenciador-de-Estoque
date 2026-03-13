<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'telefone',
        'email',
        'ativo'
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function depositos()
    {
        return $this->hasMany(Deposito::class);
    }
}
