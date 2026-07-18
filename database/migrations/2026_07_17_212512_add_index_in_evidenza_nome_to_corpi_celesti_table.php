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
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->index(['in_evidenza', 'nome']);
        });
    }

    public function down(): void
    {
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropIndex(['in_evidenza', 'nome']);
        });
    }
};
