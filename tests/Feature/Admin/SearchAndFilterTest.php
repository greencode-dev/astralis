<?php

namespace Tests\Feature\Admin;

use App\Models\Categoria;
use App\Models\CorpoCeleste;
use App\Models\Curiosita;
use App\Models\GalleriaCorpo;
use App\Models\Missione;

class SearchAndFilterTest extends AdminTestCase
{
    public function test_corpi_search_filters_by_nome(): void
    {
        CorpoCeleste::factory()->create(['nome' => 'Saturno', 'categoria_id' => Categoria::factory()->create()->id]);
        CorpoCeleste::factory()->create(['nome' => 'Marte', 'categoria_id' => Categoria::factory()->create()->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.index', ['search' => 'Sat']));

        $response->assertStatus(200);
        $response->assertSee('Saturno');
        $response->assertDontSee('Marte');
    }

    public function test_corpi_search_filters_by_nome_it(): void
    {
        CorpoCeleste::factory()->create(['nome' => 'Earth', 'nome_it' => 'Terra', 'categoria_id' => Categoria::factory()->create()->id]);
        CorpoCeleste::factory()->create(['nome' => 'Mars', 'nome_it' => 'Marte', 'categoria_id' => Categoria::factory()->create()->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.index', ['search' => 'Terr']));

        $response->assertStatus(200);
        $response->assertSee('Terra');
        $response->assertDontSee('Marte');
    }

    public function test_categorie_search_filters_by_nome(): void
    {
        Categoria::factory()->create(['nome' => 'Pianeta']);
        Categoria::factory()->create(['nome' => 'Stella']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.categorie.index', ['search' => 'Pian']));

        $response->assertStatus(200);
        $response->assertSee('Pianeta');
        $response->assertDontSee('Stella');
    }

    public function test_missioni_search_filters_by_nome(): void
    {
        Missione::factory()->create(['nome' => 'Apollo 11']);
        Missione::factory()->create(['nome' => 'Voyager 1']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.missioni.index', ['search' => 'Apollo']));

        $response->assertStatus(200);
        $response->assertSee('Apollo 11');
        $response->assertDontSee('Voyager');
    }

    public function test_missioni_filter_by_stato(): void
    {
        Missione::factory()->create(['nome' => 'Done', 'stato' => 'Completata']);
        Missione::factory()->create(['nome' => 'Active', 'stato' => 'In corso']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.missioni.index', ['stato' => 'Completata']));

        $response->assertStatus(200);
        $response->assertSee('Done');
        $response->assertDontSee('Active');
    }

    public function test_curiosita_search_filters_by_titolo(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => Categoria::factory()->create()->id]);
        Curiosita::factory()->create(['titolo' => 'Fatto sulla Terra', 'corpo_celeste_id' => $corpo->id]);
        Curiosita::factory()->create(['titolo' => 'Fatto su Marte', 'corpo_celeste_id' => $corpo->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.curiosita.index', ['search' => 'Terra']));

        $response->assertStatus(200);
        $response->assertSee('Fatto sulla Terra');
        $response->assertDontSee('Fatto su Marte');
    }

    public function test_galleria_search_filters_by_didascalia(): void
    {
        $corpo = CorpoCeleste::factory()->create(['categoria_id' => Categoria::factory()->create()->id]);
        GalleriaCorpo::factory()->for($corpo)->create(['didascalia' => 'Vista dalla Luna']);
        GalleriaCorpo::factory()->for($corpo)->create(['didascalia' => 'Cratere sul Marte']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.galleria.index', ['search' => 'Luna']));

        $response->assertStatus(200);
        $response->assertSee('Vista dalla Luna');
        $response->assertDontSee('Cratere sul Marte');
    }

    public function test_search_escapes_wildcard_percent(): void
    {
        CorpoCeleste::factory()->create(['nome' => '100% Test', 'categoria_id' => Categoria::factory()->create()->id]);
        CorpoCeleste::factory()->create(['nome' => 'Normal', 'categoria_id' => Categoria::factory()->create()->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.index', ['search' => '100%']));

        $response->assertStatus(200);
        $response->assertDontSee('Normal');
    }

    public function test_search_escapes_wildcard_underscore(): void
    {
        CorpoCeleste::factory()->create(['nome' => 'Test_Thing', 'categoria_id' => Categoria::factory()->create()->id]);
        CorpoCeleste::factory()->create(['nome' => 'TestThing', 'categoria_id' => Categoria::factory()->create()->id]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.corpi-celesti.index', ['search' => 'Test_Thing']));

        $response->assertStatus(200);
        $response->assertDontSee('TestThing');
    }
}
