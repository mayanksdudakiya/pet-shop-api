<?php

namespace App\StateMachine;

use Mayanksdudakiya\StateMachine\State;

final class OrderState extends State
{
    public static function config(): string
    {
        return 'states-and-transitions';
    }
}
