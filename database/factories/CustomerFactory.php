<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        
        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName . '.' . $lastName . '@' . $this->faker->safeEmailDomain),
            'phone' => $this->faker->optional()->phoneNumber,
            'address' => $this->faker->optional()->streetAddress,
            'town_id' => \App\Models\Town::where('status', true)->inRandomOrder()->first()->id ?? null,
            'is_active' => $this->faker->boolean(85),
            'is_filer' => $this->faker->boolean(30),
            'cnic' => $this->faker->optional()->numerify('#############'),
            'tax_number' => $this->faker->optional()->numerify('###########'),
            'notes' => $this->faker->optional()->sentence,
        ];
    }

    /**
     * Indicate that the customer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the customer is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the customer is a tax filer.
     */
    public function filer(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_filer' => true,
        ]);
    }

    /**
     * Indicate that the customer is not a tax filer.
     */
    public function nonFiler(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_filer' => false,
        ]);
    }

    /**
     * Generate a customer with complete address information.
     */
    public function withCompleteAddress(): static
    {
        return $this->state(fn (array $attributes) => [
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'country' => $this->faker->country,
        ]);
    }

    /**
     * Generate a customer with Pakistani address.
     */
    public function pakistani(): static
    {
        return $this->state(fn (array $attributes) => [
            'city' => $this->faker->randomElement(['Lahore', 'Karachi', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan']),
            'state' => $this->faker->randomElement(['Punjab', 'Sindh', 'Khyber Pakhtunkhwa', 'Balochistan', 'Islamabad Capital Territory']),
            'zip_code' => $this->faker->randomElement(['54000', '75500', '44000', '46000', '38000', '60000']),
            'country' => 'Pakistan',
            'cnic' => $this->faker->numerify('#############'),
            'tax_number' => $this->faker->numerify('###########'),
        ]);
    }
}
