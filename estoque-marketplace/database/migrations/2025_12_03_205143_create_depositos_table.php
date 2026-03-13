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
    Schema::create('depositos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained('clientes');
        $table->string('nome');
        $table->enum('tipo', ['PRINCIPAL', 'LOJA', 'CD_3P'])->default('PRINCIPAL');
        $table->boolean('ativo')->default(true);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('depositos');
}
};
