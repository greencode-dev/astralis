<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missioni', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->nullable()->unique();
            $table->string('logo')->nullable();
            $table->string('agenzia', 100)->nullable();
            $table->date('data_lancio')->nullable();
            $table->integer('durata_giorni')->nullable();
            $table->string('stato', 50)->default('completata');
            $table->text('descrizione')->nullable();
            $table->string('sito_web')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missioni');
    }
};
