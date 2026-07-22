<?php
// Model: nome, slug, colore, icona, descrizione. HasMany(CorpoCeleste). Rappresenta le 8 categorie astronomiche

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Categoria extends Model
{
    // Traits: HasFactory + HasSlug
    use HasFactory, HasSlug;

    // Table: categorie
    protected $table = 'categorie';

    // Fillable: nome, slug, icona, descrizione, colore
    protected $fillable = [
        'nome',
        'slug',
        'icona',
        'descrizione',
        'colore',
    ];

    // Slug: genera da 'nome'
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    // Relazione: HasMany CorpoCeleste
    public function corpiCelesti(): HasMany
    {
        return $this->hasMany(CorpoCeleste::class);
    }
}
