<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lcobucci\JWT\UnencryptedToken;

class JwtToken extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_uuid',
        'unique_id',
        'token_title',
        'restrictions',
        'permissions',
        'expires_at',
        'last_used_at',
        'refreshed_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'refreshed_at' => 'datetime',
    ];

    public static function storeToken(User $user, UnencryptedToken $token): void
    {
        $user->tokens()->create([
            'unique_id' => $token->claims()->get('jti'),
            'token_title' => 'authentication',
            'expires_at' => $token->claims()->get('exp'),
        ]);
    }

    public static function getTokenByUniqueId(UnencryptedToken $token): ?self
    {
        return self::whereUniqueId($token->claims()->get('jti'))->first();
    }

    public static function deleteToken(UnencryptedToken $token): bool
    {
        return self::whereUniqueId($token->claims()->get('jti'))->delete();
    }
}
