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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',200);
            $table->string('codigo',20);
            $table->string('descripcion',255)->nullable();
            $table->decimal('precio', 8, 2)->nullable();
            $table->boolean('activo')->default(true);
            $table->foreignId('tipo_producto_id')->constrained('tipo_productos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
