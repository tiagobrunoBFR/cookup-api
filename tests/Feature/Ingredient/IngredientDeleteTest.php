<?php

namespace Tests\Feature\Ingredient;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientDeleteTest extends TestCase
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
    public function should_return_status_code_204_when_ingredient_is_deleted()
    {
        $ingredient_id = factory('App\Models\Ingredient')->create()->id;

        $response = $this->delete($this::BASE_URL.$this::INGREDIENTS."/$ingredient_id");

        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_when_the_id_not_found()
    {

        $response = $this->delete($this::BASE_URL.$this::INGREDIENTS.'/1');

        $response->assertStatus(404);
    }
}
