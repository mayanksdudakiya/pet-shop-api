<?php

namespace Tests\Feature;

use App\Facades\JwtAuth;
use App\Models\JwtToken;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    use RefreshDatabase;

    private string $email = 'user@example.com';
    private string $password = 'userpassword';
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
    }


    /** @test */
    public function login_email_should_be_required(): void
    {
        $response = $this->postJson(route('api.user.login'), [
            'email' => '',
            'password' => $this->password,
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
        $response = $this->postJson(route('api.user.login'), [
            'email' => 'user@ in valid email address',
            'password' => $this->password,
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
        $response = $this->postJson(route('api.user.login'), [
            'email' => Str::random(310).'@example.com',
            'password' => $this->password,
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
        $response = $this->postJson(route('api.user.login'), [
            'email' => $this->email,
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
        $response = $this->postJson(route('api.user.login'), [
            'email' => $this->email,
            'password' => Str::random(51),
        ]);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'errors' => [
                'password'
            ]
        ]);
    }

    /** @test */
    public function admin_can_login(): void
    {
        $this->seed();

        $response = $this->postJson(route('api.user.login'), [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);

        $token = $response['data']['token'];

        $parsedToken = JwtAuth::parseToken($token);

        $tokenRecord = JwtToken::getTokenByUniqueId($parsedToken);

        $this->assertModelExists($tokenRecord);
    }

    /** @test */
    public function admin_can_logout(): void
    {
        $this->seed();

        $response = $this->postJson(route('api.user.login'), [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response->assertSuccessful();

        $token = $response['data']['token'];

        $parsedToken = JwtAuth::parseToken($token);

        $tokenRecord = JwtToken::getTokenByUniqueId($parsedToken);

        $response = $this->postJson(route('api.user.logout'), [], [
            'Authorization' => 'Bearer ' . $response['data']['token'],
        ]);

        $this->assertModelMissing($tokenRecord);
    }
}
