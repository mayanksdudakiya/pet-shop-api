<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lcobucci\JWT\UnencryptedToken;

/**
 * App\Models\JwtToken
 *
 * @property int $id
 * @property string $user_uuid
 * @property string $unique_id
 * @property string $token_title
 * @property mixed|null $restrictions
 * @property mixed|null $permissions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $refreshed_at
 * @method static \Database\Factories\JwtTokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereRefreshedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereTokenTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JwtToken whereUserUuid($value)
 * @mixin \Eloquent
 */
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
