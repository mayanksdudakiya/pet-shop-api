<?php

namespace Tests\Feature;

use App\Facades\JwtAuth;
use App\Models\User;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Lcobucci\JWT\Token;
use Tests\TestCase;

class JwtTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function jwt_valid_token_can_be_created(): void
    {
        $user = User::factory()->create();

        $token = JwtAuth::issueToken($user);

        $this->assertInstanceOf(Token::class, $token);
        $this->assertSame($user->uuid, $token->claims()->get('user_uuid'));
        $this->assertSame($user->type(), $token->claims()->get('access_level'));
    }

    /** @test */
    public function jwt_token_should_have_valid_expiration_time(): void
    {
        $user = User::factory()->create();
        $token = JwtAuth::issueToken($user);
        $now = new DateTimeImmutable();

        $currentTimeInUtc = Carbon::parse($now);
        $expirationTimeInUtc = Carbon::parse($token->claims()->get('exp'));

        $timeDifferenceInMinutes = $currentTimeInUtc->diffInMinutes($expirationTimeInUtc);

        $this->assertFalse($token->isExpired($now));
        $this->assertGreaterThanOrEqual($timeDifferenceInMinutes, 4);
    }
}
