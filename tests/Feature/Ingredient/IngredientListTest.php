<?php

namespace Tests\Feature\Ingredient;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->withErrors();
        factory('App\Models\Ingredient', 30)->create();
    }

    /**
     * @test
     */
    public function should_list_all_ingredients_with_paginate_and_return_status_code_200()
    {

        $response = $this->get($this::BASE_URL . $this::INGREDIENTS);
        $response->assertStatus(200);

        $responseArray = json_decode($response->getContent());
        $this->assertEquals(30, $responseArray->meta->total);
    }

    /**
     * @test
     */
    public function should_search_ingredient_by_name_and_return_status_code_200_and_ingredient_searched()
    {
        factory('App\Models\Ingredient')->create(['name' => 'tomato']);

        $data = [
            'name' => 'tomato',
        ];

        $response = $this->json('GET', $this::BASE_URL . $this::INGREDIENTS, $data);
        $response->assertStatus(200)
            ->assertJson(['data' => [['name' => 'tomato']]]);
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_0_of_data_count_when_search_by_name_return_null()
    {
        $data = [
            'name' => 'tomato',
        ];

        $response = $this->json('GET', $this::BASE_URL . $this::INGREDIENTS, $data);
        $responseArray = json_decode($response->getContent());
        $this->assertEquals(0, $responseArray->meta->total);
    }
}
