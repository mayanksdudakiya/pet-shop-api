<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case OPEN = 'open';
    case PENDING_PAYMENT = 'pending payment';
    case PAID = 'paid';
    case SHIPPED = 'shipped';
    case CANCELLED = 'cancelled';
}
