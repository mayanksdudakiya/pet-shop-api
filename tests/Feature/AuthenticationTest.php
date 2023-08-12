<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_login_email_should_be_required(): void
    {
        $response = $this->postJson(route('api.admin.login'), [
            'email' => '',
            'password' => 'admin',
        ]);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'errors' => [
                'email'
            ]
        ]);
    }

    /** @test */
    public function admin_login_email_should_be_valid_email_address(): void
    {
        $response = $this->postJson(route('api.admin.login'), [
            'email' => 'admin@',
            'password' => 'admin',
        ]);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'errors' => [
                'email'
            ]
        ]);
    }
}
