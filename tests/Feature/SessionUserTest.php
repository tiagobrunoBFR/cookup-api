<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionUserTest extends TestCase
{
    use RefreshDatabase;

    private $password;
    private $credentials;
    protected function setUp(): void
    {
        parent::setUp();
        $this->password = 'secret';
        $this->credentials = ['email' => 'tiagobruno@email.com', 'password' => $this->password];

    }

    public function test_should_authenticate_the_user_and_return_token_when_credentials_is_valid()
    {

        factory(User::class)->create(['email' => 'tiagobruno@email.com', 'password' => bcrypt($this->password)]);

        $response = $this->post('/api/authenticate', $this->credentials);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
    }

    public function test_should_return_error_unauthorized_and_status_code_401_when_credentials_is_not_valid()
    {

        factory(User::class)->create(['password' => bcrypt($this->password)]);

        $response = $this->post('/api/authenticate', $this->credentials);

        $response->assertStatus(401);

        $this->assertEquals(['error' => 'Unauthorized'], $response->json());

    }
}
