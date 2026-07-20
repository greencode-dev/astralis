<?php

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
    use HasFactory, HasSlug;

    protected $table = 'corpi_celesti';

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nome')
            ->saveSlugsTo('slug');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class)->select('id', 'nome', 'slug', 'icona', 'descrizione', 'colore');
    }

    public function galleria(): HasMany
    {
        return $this->hasMany(GalleriaCorpo::class)->orderBy('ordine');
    }

    public function curiosita(): HasMany
    {
        return $this->hasMany(Curiosita::class)->orderByDesc('created_at');
    }

    public function missioni(): BelongsToMany
    {
        return $this->belongsToMany(Missione::class, 'corpo_celeste_missione')
            ->withPivot('tipo_esplorazione', 'anno_arrivo')
            ->withTimestamps();
    }

    public function getImmagineUrlAttribute(): ?string
    {
        if (!$this->immagine) {
            return null;
        }
        if (str_starts_with($this->immagine, 'http')) {
            return $this->immagine;
        }
        if (str_starts_with($this->immagine, 'public/')) {
            return '/' . $this->immagine;
        }
        return Storage::url('corpi-celesti/' . $this->immagine);
    }
}
