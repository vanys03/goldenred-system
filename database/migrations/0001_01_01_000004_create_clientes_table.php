<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('telefono1', 20)->nullable();
            $table->string('telefono2', 20)->nullable();

            $table->date('fecha_contrato');
            $table->unsignedTinyInteger('dia_cobro'); // 1 a 31

            $table->foreignId('paquete_id')->constrained('paquetes');

            $table->string('Mac')->nullable();
            $table->string('IP')->nullable();

            $table->string('direccion', 255)->nullable();
            $table->string('coordenadas', 60)->nullable();
            $table->text('referencias')->nullable();

            $table->timestamps();

            $table->index('dia_cobro');
        });
    }

    public function down(): void {
        Schema::dropIfExists('clientes');
    }
};
