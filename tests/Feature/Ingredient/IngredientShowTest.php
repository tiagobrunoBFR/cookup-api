<?php

namespace Tests\Feature\Ingredient;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientShowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->withErrors();
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_object_of_ingredient()
    {
        $ingredient_id = factory('App\Models\Ingredient')->create(['name' => 'cebola'])->id;

        $response = $this->get($this::BASE_URL . $this::INGREDIENTS . "/$ingredient_id");

        $response->assertStatus(200);
        $response->assertJson(['data' => ['name' => 'cebola']]);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_ingredient_id_not_exists()
    {
        $response = $this->get($this::BASE_URL . $this::INGREDIENTS . '/1');

        $response->assertStatus(404);
    }
}
