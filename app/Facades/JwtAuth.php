<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

final class JwtAuth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'jwt.auth';
    }
}
