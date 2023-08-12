<?php
declare(strict_types=1);

namespace App\Services;

use App\Facades\ApiResponse;
use App\Models\User;
use DateTimeImmutable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Lcobucci\JWT\Validation\Validator;

final readonly class JwtAuth
{
    public function issueToken(User $user)
    {
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $now   = new DateTimeImmutable();
        $tokenUniqueId = (string) Str::uuid();
        $expireAt = now()->addMinutes(config('jwt.expiration'))->toDateTimeImmutable();

        return $tokenBuilder
            ->issuedBy(config('app.url')) // Configures the issuer (iss claim)
            ->permittedFor(config('app.url')) // Configures the audience (aud claim)
            ->identifiedBy($tokenUniqueId) // Configures the id (jti claim)
            ->issuedAt($now) // Configures the time that the token was issue (iat claim)
            //->canOnlyBeUsedAfter($now->modify('+1 minute')) // Configures the time that the token can be used (nbf claim)
            ->expiresAt($expireAt) // Configures the expiration time of the token (exp claim)
            ->withClaim('user_uuid', $user->uuid) // Configures a new claim, called "uid"
            ->withClaim('access_level', $user->type())
            ->getToken($this->getConfiguration()->signer(), $this->getConfiguration()->signingKey());
    }

    private function getConfiguration(): Configuration
    {
        $privateKeyPath = base_path('jwt-key.pem');
        $jwtSecretKey = config('jwt.key');

        throw_unless(file_exists($privateKeyPath), new FileNotFoundException("Jwt private key file not found."));

        return Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file($privateKeyPath),
            InMemory::base64Encoded($jwtSecretKey)
        );
    }

    public function parseToken(string $token): UnencryptedToken|JsonResponse
    {
        throw_unless($token, new AuthenticationException());

        $parser = new Parser(new JoseEncoder());

        try {
            $token = $parser->parse($token);
        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            return ApiResponse::sendError($e->getMessage());
        }
        assert($token instanceof UnencryptedToken);

        return $token;
    }

    public function validateToken(UnencryptedToken $token): bool
    {
        $validator = new Validator();

        try {
            $validator->assert($token, new IssuedBy(config('app.url')));
            $validator->assert($token, new PermittedFor(config('app.url')));
        } catch (RequiredConstraintsViolated $e) {
            Log::error($e->violations());
            return false;
        }
        return true;
    }
}
