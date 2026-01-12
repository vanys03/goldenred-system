<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes_rentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('telefono1', 20)->nullable();
            $table->unsignedTinyInteger('dia_pago'); // 1 a 31
            $table->string('direccion', 255)->nullable();
            $table->string('coordenadas', 60)->nullable();
            $table->text('referencias')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes_rentas');
    }
};
