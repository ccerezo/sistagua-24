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
        Schema::create('obsequios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('observacion',250)->nullable();
            $table->decimal('costo',10,2)->nullable();
            $table->integer('ingresos')->nullable();
            $table->integer('salidas')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obsequios');
    }
};
