<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

final class ApiResponse extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api_response';
    }
}
