<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('saldos_estoque', function (Blueprint $table) {
        $table->id();
        $table->foreignId('produto_id')->constrained('produtos');
        $table->foreignId('deposito_id')->constrained('depositos');

        $table->integer('quantidade_disponivel')->default(0);
        $table->integer('quantidade_reservada')->default(0);

        $table->timestamps();

        $table->unique(['produto_id', 'deposito_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('saldos_estoque');
}
};
