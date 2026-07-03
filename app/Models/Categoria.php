<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Categoria extends Model
{
    use HasSlug;

    protected $table = 'categorie';

    protected $fillable = [
        'nome',
        'slug',
        'icona',
        'descrizione',
        'colore',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    public function corpiCelesti(): HasMany
    {
        return $this->hasMany(CorpoCeleste::class);
    }
}
