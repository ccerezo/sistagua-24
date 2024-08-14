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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_contacto_id')->nullable()->constrained('tipo_contactos')->nullOnDelete();
            $table->string('identificacion',20)->nullable();
            $table->string('apellido1',50)->nullable();
            $table->string('apellido2',50)->nullable();
            $table->string('nombre1',50)->nullable();
            $table->string('nombre2',50)->nullable();
            $table->date('cumpleanios')->nullable();
            $table->json('telefono')->nullable();
            $table->json('correo')->nullable();
            $table->boolean('coordinar_visita')->default(false);
            $table->morphs('contactoable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
