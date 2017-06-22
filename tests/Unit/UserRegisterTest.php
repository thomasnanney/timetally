<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegisterTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testValidRegistration()
    {
        $response = $this->call('POST', '/register',
            array(
                '_token' => csrf_token(),
                'name' => 'John Smith',
                'email' => 'John@example.com',
                'password' => 'test123',
                'password_confirmation' => 'test123'
            ));

        $this->assertEquals(302, $response->getStatusCode());

        $this->assertDatabaseHas('users', [
            'name' => 'John Smith',
        ]);
    }

    public function testInvalidPassword()
    {
        $response = $this->call('POST', '/register',
            array(
                '_token' => csrf_token(),
                'name' => 'John Smith',
                'email' => 'John@example.com',
                'password' => 'te',
                'password_confirmation' => 'te'
            ));

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertSessionHasErrors([
            'password'
        ]);
    }

    public function testMismatchPassword()
    {
        $response = $this->call('POST', '/register',
            array(
                '_token' => csrf_token(),
                'name' => 'John Smith',
                'email' => 'John@example.com',
                'password' => 'te3',
                'password_confirmation' => 'test'
            ));

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertSessionHasErrors([
            'password'
        ]);
    }

    public function testEmptyName()
    {
        $response = $this->call('POST', '/register',
            array(
                '_token' => csrf_token(),
                'name' => '',
                'email' => 'John@example.com',
                'password' => 'te3',
                'password_confirmation' => 'test'
            ));

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertSessionHasErrors([
            'name'
        ]);
    }

    public function testEmptyEmail()
    {
        $response = $this->call('POST', '/register',
            array(
                '_token' => csrf_token(),
                'name' => 'John Smith',
                'email' => '',
                'password' => 'te3',
                'password_confirmation' => 'test'
            ));

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertSessionHasErrors([
            'email'
        ]);
    }

    public function testInvalidEmail()
    {
        $response = $this->call('POST', '/register',
            array(
                '_token' => csrf_token(),
                'name' => 'John Smith',
                'email' => 'Johnny',
                'password' => 'test123',
                'password_confirmation' => 'test123'
            ));

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertSessionHasErrors([
            'email'
        ]);
    }
}
