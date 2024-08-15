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
        Schema::create('productoables', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad')->default(1);
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete();
            $table->morphs('productoable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productoables');
    }
};
