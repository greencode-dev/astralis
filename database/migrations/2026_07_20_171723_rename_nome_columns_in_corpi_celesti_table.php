<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reverse swap: nome (English) → nome_en, nome_it (Italian) → nome.
     * Regenerates slugs from Italian names.
     */
    public function up(): void
    {
        // 1. Drop composite index that references old 'nome'
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropIndex(['in_evidenza', 'nome']);
        });

        // 2. Add nome_en column (English name, nullable)
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->string('nome_en', 255)->nullable()->after('nome');
        });

        // 3. Copy nome (English) → nome_en for rows that have nome_it
        DB::table('corpi_celesti')
            ->whereNotNull('nome_it')
            ->update(['nome_en' => DB::raw('nome')]);

        // 4. Overwrite nome with nome_it (Italian) where available
        DB::table('corpi_celesti')
            ->whereNotNull('nome_it')
            ->update(['nome' => DB::raw('nome_it')]);

        // 5. Drop nome_it
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropColumn('nome_it');
        });

        // 6. Regenerate slugs from Italian names
        $this->regenerateSlugs();

        // 7. Recreate composite index on [in_evidenza, nome]
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->index(['in_evidenza', 'nome']);
        });
    }

    /**
     * Reverse: nome → nome_it, nome_en → nome.
     */
    public function down(): void
    {
        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropIndex(['in_evidenza', 'nome']);
        });

        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->string('nome_it', 255)->nullable()->after('nome');
        });

        DB::table('corpi_celesti')
            ->whereNotNull('nome_en')
            ->update(['nome_it' => DB::raw('nome')]);

        DB::table('corpi_celesti')
            ->whereNotNull('nome_en')
            ->update(['nome' => DB::raw('nome_en')]);

        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->dropColumn('nome_en');
        });

        $this->regenerateSlugs();

        Schema::table('corpi_celesti', function (Blueprint $table) {
            $table->index(['in_evidenza', 'nome']);
        });
    }

    /**
     * Generate URL-friendly slugs from the 'nome' column.
     */
    private function regenerateSlugs(): void
    {
        $rows = DB::table('corpi_celesti')->select('id', 'nome')->get();
        $usedSlugs = [];

        foreach ($rows as $row) {
            $slug = $this->makeSlug($row->nome, $usedSlugs);
            $usedSlugs[] = $slug;
            DB::table('corpi_celesti')
                ->where('id', $row->id)
                ->update(['slug' => $slug]);
        }
    }

    /**
     * Convert a name to a URL-friendly slug, handling duplicates.
     */
    private function makeSlug(string $name, array $usedSlugs): string
    {
        $slug = mb_strtolower($name, 'UTF-8');
        // Transliterate common Italian chars
        $slug = str_replace(
            ['à', 'á', 'â', 'ã', 'ä', 'å', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'ñ', 'ç', 'œ', 'æ'],
            ['a', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'n', 'c', 'oe', 'ae'],
            $slug
        );
        // Replace non-alphanumeric chars (except hyphens) with hyphens
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        // Collapse multiple hyphens
        $slug = preg_replace('/-+/', '-', $slug);
        // Trim hyphens from ends
        $slug = trim($slug, '-');

        // Handle duplicates
        $originalSlug = $slug;
        $counter = 1;
        while (in_array($slug, $usedSlugs)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
};
