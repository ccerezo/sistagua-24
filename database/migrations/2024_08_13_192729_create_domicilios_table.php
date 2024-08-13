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
        Schema::create('domicilios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',15);
            $table->string('identificacion',20)->nullable();
            $table->string('apellido1',50);
            $table->string('apellido2',50)->nullable();
            $table->string('nombre1',50);
            $table->string('nombre2',50)->nullable();
            $table->date('cumpleanios')->nullable();
            $table->json('celular');
            $table->json('images');
            $table->json('correo');
            $table->boolean('coordinar_visita')->default(false);
            
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
            $table->foreignId('grupo_id')->nullable()->constrained('grupos')->nullOnDelete();
            $table->foreignId('precio_id')->nullable()->constrained('precios')->nullOnDelete();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicilios');
    }
};
