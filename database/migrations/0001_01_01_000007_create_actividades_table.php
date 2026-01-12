<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->date('fecha');
            $table->time('hora_entrada');
            $table->time('hora_salida')->nullable();

            $table->string('ip', 45)->nullable();
            $table->string('dispositivo', 120)->nullable();

            $table->timestamps();

            $table->index(['usuario_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
