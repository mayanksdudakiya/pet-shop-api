<?php

namespace App\StateMachine;

use Mayanksdudakiya\StateMachine\State;

final class PaymentState extends State
{
    public static function config(): string
    {
        return 'pay-states-and-transitions';
    }
}
