<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

final class BaseAuth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'base.auth';
    }
}
