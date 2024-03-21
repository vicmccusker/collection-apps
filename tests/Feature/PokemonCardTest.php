<?php

namespace Tests\Feature;

use App\Models\PokemonCard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PokemonCardTest extends TestCase
{
    use DatabaseMigrations;

    public function test_getPokemonCards(): void
    {
        PokemonCard::factory()->count(2)->create();
        $response = $this->getJson('/api/pokemon-cards');
        $response->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->whereType('message', 'string')
                    ->has('data', 2, function (AssertableJson $json) {
                        $json->hasAll(['id', 'name', 'HP', 'FirstSkill', 'Weakness', 'Rating', 'Got'])
                            ->whereAllType([
                                'id' => 'integer',
                                'name' => 'string',
                                'HP' => 'integer',
                                'FirstSkill' => 'string',
                                'Weakness' => 'string',
                                'Rating' => 'integer',
                                'Got' => 'integer']);
                    });

            });
    }

    public function test_getSingleCard()
    {

        PokemonCard::factory()->count(2)->create();
        $response = $this->getJson('/api/pokemon-cards/1');
        $response->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->whereType('message', 'string')
                    ->has('data', function (AssertableJson $json) {
                        $json->hasAll(['id', 'name', 'HP', 'FirstSkill', 'Weakness', 'Rating', 'Got'])
                            ->whereAllType([
                                'id' => 'integer',
                                'name' => 'string',
                                'HP' => 'integer',
                                'FirstSkill' => 'string',
                                'Weakness' => 'string',
                                'Rating' => 'integer',
                                'Got' => 'integer']);
                    });
            });
    }
}
