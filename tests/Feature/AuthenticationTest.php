<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_email_should_be_required(): void
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
    public function login_email_should_be_valid_email_address(): void
    {
        $response = $this->postJson(route('api.admin.login'), [
            'email' => 'admin@ in valid email address',
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
    public function login_email_length_should_be_validated(): void
    {
        $response = $this->postJson(route('api.admin.login'), [
            'email' => Str::random(310).'@example.com',
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
    public function login_password_should_be_required(): void
    {
        $response = $this->postJson(route('api.admin.login'), [
            'email' => DatabaseSeeder::ADMIN_EMAIL,
            'password' => '',
        ]);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'errors' => [
                'password'
            ]
        ]);
    }

    /** @test */
    public function login_password_length_should_be_validated(): void
    {
        $response = $this->postJson(route('api.admin.login'), [
            'email' => DatabaseSeeder::ADMIN_EMAIL,
            'password' => Str::random(51),
        ]);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'errors' => [
                'password'
            ]
        ]);
    }
}
