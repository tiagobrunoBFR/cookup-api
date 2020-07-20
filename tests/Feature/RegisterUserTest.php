<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{

    use RefreshDatabase;

    private $data_user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->data_user = [
            'name' => 'teste',
            'email' => 'teste@email.com',
            'password' => 'secret'
        ];

    }

    public function test_should_return_status_code_201_and_token_when_user_pass_params_valid()
    {

        $response = $this->post('/api/register', $this->data_user);
        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
    }

    /**
     * @dataProvider validatorProvider
     */

    public function test_should_return_message_error($data, $inputValidation)
    {

        $response = $this->post('/api/register',$data);
        $response->assertStatus(422)
        ->assertJsonValidationErrors($inputValidation);

    }

    public function test_should_return_message_error_when_email_exists_in_database(){

        factory(User::class)->create(['email' => 'teste@email.com']);

        $response = $this->post('/api/register', $this->data_user);
        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function validatorProvider()
    {
        return [
            'when_name_is_null' => [
                'data' => [
                    'name' => '',
                    'password' => '123456',
                    'email' => 'teste@email.com'
                ],
                'inputValidation' => 'name',

            ],
            'when_email_is_null' => [
                'data' => [
                    'name' => 'teste',
                    'password' => '123456',
                    'email' => ''
                ],
                'inputValidation' => 'email',
                'textError' => 'The email field is required.'

            ],
            'when_email_is_invalid' => [
                'data' => [
                    'name' => 'teste',
                    'password' => 'secret',
                    'email' => 'teste-teste'
                ],
                'inputValidation' => 'email',
                'textError' => 'The email must be a valid email address.'
            ],
            'when_password_is_null' => [
                'data' => [
                    'name' => 'teste',
                    'password' => '',
                    'email' => 'teste@email'
                ],
                'inputValidation' => 'password',
                'textError' => 'The password field is required.'
            ],
        ];
    }

}
