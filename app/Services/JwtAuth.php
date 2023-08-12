<?php

namespace App\Services;

use App\Models\User;
use DateTimeImmutable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Rsa\Sha256;

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
}