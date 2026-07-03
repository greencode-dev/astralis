<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corpo_celeste_missione', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corpo_celeste_id')->constrained('corpi_celesti')->cascadeOnDelete();
            $table->foreignId('missione_id')->constrained('missioni')->cascadeOnDelete();
            $table->string('tipo_esplorazione', 50)->nullable();
            $table->year('anno_arrivo')->nullable();
            $table->timestamps();

            $table->unique(['corpo_celeste_id', 'missione_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpo_celeste_missione');
    }
};
