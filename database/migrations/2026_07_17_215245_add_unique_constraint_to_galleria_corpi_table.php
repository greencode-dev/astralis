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
        Schema::table('galleria_corpi', function (Blueprint $table) {
            $table->unique(['corpo_celeste_id', 'percorso']);
        });
    }

    public function down(): void
    {
        Schema::table('galleria_corpi', function (Blueprint $table) {
            $table->dropUnique(['corpo_celeste_id', 'percorso']);
        });
    }
};
