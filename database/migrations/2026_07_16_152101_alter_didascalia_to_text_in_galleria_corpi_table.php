<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleria_corpi', function (Blueprint $table) {
            $table->text('didascalia')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('galleria_corpi', function (Blueprint $table) {
            $table->string('didascalia')->nullable()->change();
        });
    }
};
