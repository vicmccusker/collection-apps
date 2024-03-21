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

    public function test_addPokemonCardSuccess(): void
    {
        PokemonCard::factory()->create();
        $response = $this->postJson('/api/pokemon-cards', [
            'name' => 'test',
            'HP' => 1,
            'FirstSkill' => 'test',
            'Weakness' => 'test',
            'Rating' => 1,
            'Got' => 1,
        ]);

        $response->assertStatus(401)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });

        $this->assertDatabaseHas('pokemon_cards', [
            'name' => 'test',
            'HP' => 1,
            'FirstSkill' => 'test',
            'Weakness' => 'test',
            'Rating' => 1,
            'Got' => 1,
        ]);
    }

    public function test_createPokemonCard_invalidData(): void
    {

        $response = $this->postJson('/api/pokemon-cards', []);
        $response->assertInvalid(['name', 'HP', 'FirstSkill', 'Weakness', 'Rating', 'Got']);
    }

    public function test_updatingPokemonCardSuccess(): void
    {
        PokemonCard::factory()->create();
        $response = $this->putJson('/api/pokemon-cards/1', [
            'name' => 'test',
            'HP' => 1,
            'FirstSkill' => 'Test',
            'Weakness' => 'test',
            'Rating' => 1,
            'Got' => 1,
        ]);

        $response->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });

        $this->assertDatabaseHas('pokemon_cards', [
            'name' => 'test',
            'HP' => 1,
            'FirstSkill' => 'Test',
            'Weakness' => 'test',
            'Rating' => 1,
            'Got' => 1,
        ]);
    }

    public function test_updatingCardsNotFound(): void
    {
        $response = $this->putJson('/api/pokemon-cards/1', [
            'name' => 'test',
            'HP' => 1,
            'FirstSkill' => 'Test',
            'Weakness' => 'test',
            'Rating' => 1,
            'Got' => 1]);

        $response->assertStatus(400)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');

            });
    }

    public function test_updatingCardInvalidData(): void
    {
        PokemonCard::factory()->create();
        $response = $this->putJson('/api/pokemon-cards/1', []);
        $this->assertInvalidCredentials(['name', 'HP', 'FirstSkill', 'Weakness', 'Rating', 'Got']);
    }

    public function test_deleteCardSuccess():void
    {
        $card = PokemonCard::factory()->create();

        $response = $this->deleteJson('/api/pokemon-cards/1');

        $response->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });

        $this->assertDatabaseMissing('pokemon_cards', [
            'name' => $card->name
        ]);

    }
}
