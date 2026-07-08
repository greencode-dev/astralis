<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->index('tipo');
            $table->index('in_evidenza');
        });

        Schema::table('galleria_corpi', function (Blueprint $table) {
            $table->index('ordine');
        });
    }

    public function down(): void
    {
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropIndex(['tipo']);
            $table->dropIndex(['in_evidenza']);
        });

        Schema::table('galleria_corpi', function (Blueprint $table) {
            $table->dropIndex(['ordine']);
        });
    }
};
