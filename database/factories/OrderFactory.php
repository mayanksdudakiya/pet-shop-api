<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $payment = Payment::factory()->create();
        $orderStatus = OrderStatus::factory()->create();
        $product = Product::factory()->create();
        $productQuantity = rand(1, 5);
        $productAmount = $productQuantity * $product->price;

        return [
            'user_uuid' => $user->uuid,
            'order_status_uuid' => $orderStatus->uuid,
            'payment_uuid' => $payment->uuid,
            'uuid' => fake()->unique()->uuid(),
            'products' => [
                [
                    'product' => $product->uuid,
                    'quantity' => $productQuantity,
                ]
            ],
            'address' => [
                'billing' => fake()->address(),
                'shipping' => fake()->address(),
            ],
            'delivery_fee' => $productAmount > 500 ? 15 : null,
            'amount' => $productAmount,
            'shipped_at' => $orderStatus->title === OrderStatusEnum::SHIPPED->value ? date('Y-m-d h:m:s') : null,
        ];
    }
}
