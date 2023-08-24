<?php

namespace Database\Factories;

use App\Enums\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentType = fake()->randomElement(array_column(PaymentTypeEnum::cases(), 'value'));

        return [
            'uuid' => fake()->unique()->uuid(),
            'type' => $paymentType,
            'details' => $this->getPaymentDetails($paymentType),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function getPaymentDetails(string $paymentType): array
    {
        return match ($paymentType) {
            PaymentTypeEnum::CREDIT_CARD->value => [
                'holder_name' => fake()->name(),
                'number' => fake()->creditCardNumber(),
                'ccv' => fake()->randomNumber(3),
                'expire_date' => fake()->creditCardExpirationDate(),
            ],
            PaymentTypeEnum::BANK_TRANSFER->value => [
                'swift' => fake()->swiftBicNumber(),
                'iban' => fake()->iban(),
                'name' => fake()->name(),
            ],
            default => [
                'first_name' => fake()->name(),
                'last_name' => fake()->lastName(),
                'address' => fake()->address(),
            ],
        };
    }
}
