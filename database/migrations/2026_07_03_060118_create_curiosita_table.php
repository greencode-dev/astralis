<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curiosita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corpo_celeste_id')->constrained('corpi_celesti')->cascadeOnDelete();
            $table->string('titolo');
            $table->text('descrizione');
            $table->string('fonte')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curiosita');
    }
};
