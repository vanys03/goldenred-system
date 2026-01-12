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
        Schema::create('rentas', function (Blueprint $table) {
            $table->id();

            // cliente de la tabla clientes_rentas
            $table->foreignId('cliente_renta_id')->constrained('clientes_rentas')->onDelete('cascade');

            // usuario que registró la renta
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->unsignedSmallInteger('meses')->default(1);

            $table->decimal('descuento', 8, 2)->default(0);
            $table->decimal('recargo_domicilio', 8, 2)->default(0);

            $table->date('fecha_venta');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);

            $table->timestamps();
            $table->string('estado')->default('activa'); // activa, devuelta, cancelada

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentas');
    }
};
