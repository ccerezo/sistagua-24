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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->dateTime('fecha', $precision = 0);
            $table->text('observacion')->nullable();
            $table->morphs('visitaable');
            $table->boolean('realizada')->default(false);
            $table->integer('estado_visita_id')->constrained('estado_visitas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
