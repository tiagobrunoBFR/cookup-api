<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory('App\Models\User')->create();

        $this->actingAs($user);

        return $user;
    }


    protected function withErrors()
    {
        $this->withoutExceptionHandling();
    }
}
