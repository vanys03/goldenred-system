<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('equipo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Relación con clientes
            $table->string('marca_antena');
            $table->string('modelo_antena');
            $table->string('numero_serie_antena')->unique();
            $table->string('marca_router');
            $table->string('modelo_router');
            $table->string('numero_serie_router')->unique();
            $table->timestamps();

            // Clave foránea
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipo');
    }
};
