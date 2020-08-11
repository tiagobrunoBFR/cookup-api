<?php

namespace Tests\Feature\Ingredient;

use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class IngredientUpdateTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withErrors();
        $this->signIn();
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_object_updated()
    {

       $ingredient_id = factory(Ingredient::class)->create()->id;

       $data = [
           'name' => 'cebola'
       ];

        $response = $this->put($this::BASE_URL.$this::INGREDIENTS."/$ingredient_id", $data);

        $response->assertStatus(200);
        $response->assertJson(['data' => ['name' => 'cebola']]);
    }

    /**
     * @test
     */
    public function should_return_status_code_404_and_message_not_found_when_ingredient_not_exist_in_database()
    {
        $data = [
            'name' => $this->faker->name
        ];

        $response = $this->put($this::BASE_URL.$this::INGREDIENTS.'/1', $data);
        $response->assertStatus(404);
        $response->assertJson(['error' => 'Not Found']);
    }

    /**
     * @test
     */
    public function should_return_error_when_image_is_invalid()
    {


        $data = [
            'name' => $this->faker->name,
            'image' => $this->faker->name
        ];

        $ingredient_id = factory(Ingredient::class)->create()->id;


        $response = $this->put($this::BASE_URL.$this::INGREDIENTS."/$ingredient_id", $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    /**
     * @test
     */
    public function should_return_a_error_when_name_is_blank()
    {

        $data = [
            'name' => '',
        ];

        $ingredient_id = factory(Ingredient::class)->create()->id;


        $response = $this->put($this::BASE_URL.$this::INGREDIENTS."/$ingredient_id", $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }
}
