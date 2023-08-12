<?php

namespace App\Models;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Lcobucci\JWT\UnencryptedToken;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'is_admin',
        'email',
        'password',
        'avatar',
        'address',
        'phone_number',
        'is_marketing',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'is_marketing' => 'boolean',
        'is_admin' => 'boolean',
    ];

    /**
     * @return HasMany<JwtToken>
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(JwtToken::class, 'user_uuid', 'uuid');
    }

    public function type(): string
    {
        return $this->is_admin ? UserTypeEnum::ADMIN->value : UserTypeEnum::USER->value;
    }

    public static function setAuthenticatedUserInRequest(UnencryptedToken $token, Request $request): void
    {
        $user = self::whereUuid($token->claims()->get('user_uuid'))->firstOrFail();
        $request->merge(['user' => $user]);
    }
}
