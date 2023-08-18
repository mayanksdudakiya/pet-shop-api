<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_uuid',
        'order_status_uuid',
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
    ];

    /**
     * @return HasOne<OrderStatus>
     */
    public function status(): HasOne
    {
        return $this->hasOne(OrderStatus::class, 'uuid', 'order_status_uuid');
    }

    /**
     * @return HasOne<OrderStatus>
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'uuid', 'payment_uuid');
    }
}
