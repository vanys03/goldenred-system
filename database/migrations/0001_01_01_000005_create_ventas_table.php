<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('cliente_id')->constrained('clientes');

            $table->enum('estado', ['pendiente', 'pagado', 'atrasado', 'cancelado'])->default('pendiente');

            $table->unsignedSmallInteger('meses')->default(1);

            $table->decimal('descuento', 8, 2)->default(0);
            $table->decimal('recargo_domicilio', 8, 2)->default(0);
            $table->decimal('recargo_mora', 8, 2)->default(0);

            $table->date('fecha_venta');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);

            $table->timestamps();

            $table->index(['cliente_id', 'fecha_venta']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('ventas');
    }
};
