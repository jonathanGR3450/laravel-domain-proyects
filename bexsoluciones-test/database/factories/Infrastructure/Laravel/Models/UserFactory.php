<?php

namespace Database\Factories\Infrastructure\Laravel\Models;

use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Models\TypeDocument;
use App\Infrastructure\Laravel\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model. * * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => Id::random()->value(),
            'name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'identification' => fake()->numberBetween(1, 30000),
            'is_verified' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => null,
            'password' => Hash::make('Lol123Lol@'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
