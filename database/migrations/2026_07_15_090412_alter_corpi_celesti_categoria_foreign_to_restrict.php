<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->foreign('categoria_id')->references('id')->on('categorie')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->foreign('categoria_id')->references('id')->on('categorie')->cascadeOnDelete();
        });
    }
};
