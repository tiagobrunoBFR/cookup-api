<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class IngredientCreateTest extends TestCase
{

    use RefreshDatabase;

    private $baseUrl;
    private $image;
    protected function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = $this::BASE_URL.$this::INGREDIENTS;
        $this->withErrors();
        $this->signIn();
        Storage::fake('public');
        $this->image = UploadedFile::fake()->image('avatar.jpg');
    }


    /**
     * @test
     */
    public function should_register_a_ingredient_and_return_response_status_code_201()
    {

        $data = [
            'name' => 'salt',
            'image' => $this->image
        ];

        $response = $this->post($this->baseUrl, $data);
        $response->assertStatus(201);

        Storage::disk('public')->assertExists('ingredients/'.$this->image->hashName());
        $this->assertDatabaseHas('ingredients', [
            'name' => 'salt',
        ]);
    }

    /**
     * @test
     */
    public function should_return_a_status_code_422_when_name_of_ingredient_exists_in_database()
    {

        $data = [
            'name' => 'salt',
            'image' => $this->image
        ];

        $this->post($this->baseUrl, $data);

        $response = $this->post($this->baseUrl, $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');

    }


    /**
     * @test
     */
    public function should_return_error_when_image_is_invalid()
    {

        $image = UploadedFile::fake()->image('file.pdf');

        $data = [
            'name' => 'salt',
            'image' => $image
        ];

        $response = $this->post($this->baseUrl, $data);

        $response->assertJsonValidationErrors('image');
    }

    /**
     * @test
     * @dataProvider providerErrorBlank
     */
    public function should_return_error_when_input_is_blank($data, $inputErro)
    {
        $response = $this->post($this->baseUrl, $data);

        $response->assertJsonValidationErrors($inputErro);
    }

    public function providerErrorBlank()
    {
        return [
            'when name is blank' => [
                'data' => [
                    'name' => '',
                    'image' => $this->image
                ],
                'inputErro' => 'name'
            ],
            'when image is blank' => [
                'data' => [
                    'name' => 'salt',
                    'image' => ''
                ],
                'inputErro' => 'image'
            ]
        ];
    }
}
