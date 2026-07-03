<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleria_corpi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corpo_celeste_id')->constrained('corpi_celesti')->cascadeOnDelete();
            $table->string('percorso');
            $table->string('didascalia')->nullable();
            $table->string('crediti')->nullable();
            $table->integer('ordine')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleria_corpi');
    }
};
