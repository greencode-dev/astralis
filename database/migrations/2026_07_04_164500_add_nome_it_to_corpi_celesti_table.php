<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $nameMap = [
        'Sole'     => 'Sun',
        'Mercurio' => 'Mercury',
        'Venere'   => 'Venus',
        'Terra'    => 'Earth',
        'Marte'    => 'Mars',
        'Giove'    => 'Jupiter',
        'Saturno'  => 'Saturn',
        'Urano'    => 'Uranus',
        'Nettuno'  => 'Neptune',
        'Luna'     => 'Moon',
        'Titano'   => 'Titan',
        'Via Lattea' => 'Milky Way',
        'Nebulosa di Orione' => 'Orion Nebula',
        'Cometa di Halley' => "Halley's Comet",
        'Cerere'   => 'Ceres',
        'Plutone'  => 'Pluto',
    ];

    public function up(): void
    {
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->string('nome_it', 255)->nullable()->after('nome');
        });

        foreach ($this->nameMap as $it => $en) {
            DB::table('corpi_celesti')
                ->where('nome', $it)
                ->update([
                    'nome_it' => $it,
                    'nome' => $en,
                ]);
        }
    }

    public function down(): void
    {
        foreach ($this->nameMap as $it => $en) {
            DB::table('corpi_celesti')
                ->where('nome', $en)
                ->where('nome_it', $it)
                ->update([
                    'nome' => $it,
                    'nome_it' => null,
                ]);
        }

        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropColumn('nome_it');
        });
    }
};
