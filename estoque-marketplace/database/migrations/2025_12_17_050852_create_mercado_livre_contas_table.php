<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mercado_livre_contas', function (Blueprint $table) {
    $table->string('seller_id')->nullable()->unique();
    $table->string('client_id')->nullable();
    $table->string('client_secret')->nullable();
    $table->text('access_token')->nullable();
    $table->text('refresh_token')->nullable();
    $table->timestamp('token_expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mercado_livre_contas');
    }
};
