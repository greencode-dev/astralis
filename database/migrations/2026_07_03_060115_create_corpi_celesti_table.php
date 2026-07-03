<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corpi_celesti', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->nullable()->unique();
            $table->foreignId('categoria_id')->constrained('categorie')->cascadeOnDelete();
            $table->string('immagine')->nullable();
            $table->text('descrizione')->nullable();
            $table->string('tipo', 50)->nullable();
            $table->string('massa_kg', 50)->nullable();
            $table->string('distanza_km', 50)->nullable();
            $table->string('diametro_km', 50)->nullable();
            $table->decimal('gravita', 10, 4)->nullable();
            $table->decimal('temperatura', 10, 2)->nullable();
            $table->decimal('periodo_orbitale', 20, 6)->nullable();
            $table->string('scopritore', 100)->nullable();
            $table->integer('anno_scoperta')->nullable();
            $table->boolean('in_evidenza')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corpi_celesti');
    }
};
