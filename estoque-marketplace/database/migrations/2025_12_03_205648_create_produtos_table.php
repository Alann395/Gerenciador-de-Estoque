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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();

            // Removido cliente_id 👍

            $table->string('sku_interno')->unique();
            $table->string('nome');
            $table->string('codigo_barras')->nullable();

            $table->decimal('peso', 10, 3)->nullable();
            $table->decimal('altura', 10, 2)->nullable();
            $table->decimal('largura', 10, 2)->nullable();
            $table->decimal('comprimento', 10, 2)->nullable();

            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
