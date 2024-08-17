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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('control_id')->nullable()->constrained('controls')->nullOnDelete();
            $table->enum('tipo_doc', ['Factura','Recibo'])->default('Factura');
            $table->string('numero')->nullable();
            $table->string('numero_ficha')->nullable();
            $table->timestamp('fecha')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('tds')->nullable();
            $table->integer('ppm')->nullable();
            $table->longText('firma')->nullable();
            $table->foreignId('autoriza_id')->nullable()->constrained('autorizas')->nullOnDelete();
            $table->boolean('notificado')->default(false);
            $table->integer('persona_matenimiento_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
