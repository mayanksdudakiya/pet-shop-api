<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
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
            'validation_errors' => [
                'email'
            ]
        ]);
    }
}
