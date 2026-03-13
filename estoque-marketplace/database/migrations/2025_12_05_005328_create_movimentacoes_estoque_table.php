<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_variacao_id')
                  ->constrained('produto_variacoes')
                  ->onDelete('cascade');

            $table->enum('tipo', ['entrada', 'saida']);
            $table->integer('quantidade');
            $table->string('motivo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes');
    }
};
