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
        Schema::create('entregadoables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obsequio_id')->constrained('obsequios')->cascadeOnDelete();
            $table->foreignId('contacto_id')->nullable()->constrained('contactos')->nullOnDelete();
            $table->integer('cantidad')->default(1);
            $table->string('observacion', 200)->nullable();
            $table->morphs('entregadoable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregadoables');
    }
};
