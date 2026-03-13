<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integracao_pedidos', function (Blueprint $table) {
            $table->id();

            // marketplace onde veio o pedido (mercado_livre, shopee, ml etc)
            $table->string('marketplace');

            // ID real vindo da plataforma (ex: id do pedido no ML)
            $table->string('pedido_id_plataforma')->index();

            // status interno do processamento
            $table->string('status')->default('processado');

            // armazenar o payload original
            $table->json('payload')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integracao_pedidos');
    }
};
