<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Deposito;

class SetupInicialSeeder extends Seeder
{
    public function run(): void
    {
        // Criar cliente inicial
        $cliente = Cliente::create([
            'nome_fantasia' => 'Cliente Padrão',
            'razao_social' => 'Empresa Padrão LTDA',
            'cnpj' => null,
            'telefone' => null,
            'email' => null,
            'ativo' => true,
        ]);

        // Criar depósito principal
        Deposito::create([
            'cliente_id' => $cliente->id,
            'nome' => 'Depósito Principal',
            'tipo' => 'PRINCIPAL',
            'ativo' => true,
        ]);

        // Criar usuário admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => bcrypt('123456'),
            'cliente_id' => $cliente->id,
            'role' => 'admin',
        ]);
    }
}
