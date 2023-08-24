<?php

namespace App\Models;

use App\StateMachine\OrderState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Mayanksdudakiya\StateMachine\StateMachine;

class Order extends Model
{
    use HasFactory;
    use StateMachine;

    protected $fillable = [
        'user_uuid',
        'order_status',
        'payment_uuid',
        'uuid',
        'products',
        'address',
        'delivery_fee',
        'amount',
        'shipped_at',
    ];

    protected $casts = [
        'products' => 'json',
        'address' => 'json',
        'shipped_at' => 'timestamp',
        'order_status' => OrderState::class,
    ];

    /**
     * @return HasOne<Payment>
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'uuid', 'payment_uuid');
    }
}
