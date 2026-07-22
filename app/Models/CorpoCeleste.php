<?php
// Model: 18 campi, BelongsTo(Categoria), HasMany(Galleria,Curiosità), BelongsToMany(Missione). Slug da nome italiano

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CorpoCeleste extends Model
{
    // Traits: HasFactory (factory), HasSlug (spatie sluggable)
    use HasFactory, HasSlug;

    // Table name esplicito: corpi_celesti
    protected $table = 'corpi_celesti';

    // Fillable: 18 campi, include nome (IT) e nome_en (EN)
    protected $fillable = [
        'nome',
        'nome_en',
        'slug',
        'categoria_id',
        'immagine',
        'descrizione',
        'tipo',
        'massa_kg',
        'distanza_km',
        'diametro_km',
        'gravita',
        'temperatura',
        'periodo_orbitale',
        'scopritore',
        'anno_scoperta',
        'in_evidenza',
        'nasa_id',
        'immagine_utente',
    ];

    // Casts: decimal per precisione numerica, integer per anno, boolean per flag
    protected function casts(): array
    {
        return [
            'gravita' => 'decimal:4',
            'temperatura' => 'decimal:2',
            'periodo_orbitale' => 'decimal:4',
            'anno_scoperta' => 'integer',
            'in_evidenza' => 'boolean',
            'immagine_utente' => 'boolean',
        ];
    }

    // Slug: genera da campo 'nome' (italiano), salva in 'slug'
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    // Relazione: BelongsTo Categoria con select ottimizzato
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class)->select('id', 'nome', 'slug', 'icona', 'descrizione', 'colore');
    }

    // Relazione: HasMany GalleriaCorpo, ordinata per 'ordine'
    public function galleria(): HasMany
    {
        return $this->hasMany(GalleriaCorpo::class)->orderBy('ordine');
    }

    // Relazione: HasMany Curiosita, ordine decrescente per data
    public function curiosita(): HasMany
    {
        return $this->hasMany(Curiosita::class)->orderByDesc('created_at');
    }

    // Relazione: BelongsToMany Missione, pivot con tipo_esplorazione + anno_arrivo + timestamps
    public function missioni(): BelongsToMany
    {
        return $this->belongsToMany(Missione::class, 'corpo_celeste_missione')
            ->withPivot('tipo_esplorazione', 'anno_arrivo')
            ->withTimestamps();
    }

    // Accessor: immagine_url — gestisce 3 casi: URL http, path public/, filename locale
    public function getImmagineUrlAttribute(): ?string
    {
        if (!$this->immagine) {
            return null;
        }
        if (str_starts_with($this->immagine, 'http')) {
            return $this->immagine;
        }
        if (str_starts_with($this->immagine, 'public/')) {
            return '/' . substr($this->immagine, strlen('public/'));
        }
        return Storage::url('corpi-celesti/' . $this->immagine);
    }
}
