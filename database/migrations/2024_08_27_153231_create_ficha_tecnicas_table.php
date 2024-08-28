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
        Schema::create('ficha_tecnicas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('detalle_tds',100);
            $table->string('dureza_color_tds',100)->nullable();
            $table->text('recomendacion_tds')->nullable();
            $table->string('detalle_ppm',100)->nullable();
            $table->text('recomendacion_ppm')->nullable();
            $table->decimal('subtotal',10,2)->nullable();
            $table->decimal('iva',10,2)->nullable();
            $table->decimal('descuento',10,2)->nullable();
            $table->decimal('total',10,2)->default(0);
            $table->text('recomendacion_sistagua')->nullable();
            $table->foreignId('mantenimiento_id')->constrained('mantenimientos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ficha_tecnicas');
    }
};
