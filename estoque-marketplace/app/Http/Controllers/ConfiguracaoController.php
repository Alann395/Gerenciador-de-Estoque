<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ConfiguracaoController extends Controller
{
    // Tela de configuração
    public function index()
    {
        // Lê do .env (se não tiver, usa 10)
        $limite = env('ESTOQUE_MINIMO', 10);

        return view('configuracoes.index', compact('limite'));
    }

    // Salvar configuração
    public function update(Request $request)
    {
        $dados = $request->validate([
            'limite' => 'required|integer|min:1|max:999999',
        ]);

        $novoLimite = $dados['limite'];

        // Atualiza o .env
        $this->setEnvValue('ESTOQUE_MINIMO', $novoLimite);

        // Opcional: garante que nas próximas requisições o valor já venha certo
        // (em dev normalmente nem precisa, mas não atrapalha)
        putenv("ESTOQUE_MINIMO={$novoLimite}");

        return redirect()
            ->route('configuracoes.index')
            ->with('success', 'Configuração salva com sucesso!');
    }

    /**
     * Atualiza (ou cria) uma chave no arquivo .env
     */
    private function setEnvValue(string $key, string $value): void
    {
        $path = base_path('.env');

        if (!File::exists($path)) {
            return;
        }

        $env = File::get($path);

        if (str_contains($env, "{$key}=")) {
            // Substitui a linha inteira da chave
            $env = preg_replace(
                "/^{$key}=.*/m",
                "{$key}={$value}",
                $env
            );
        } else {
            // Se não existir a chave, adiciona no final do arquivo
            $env .= PHP_EOL."{$key}={$value}";
        }

        File::put($path, $env);
    }
}
