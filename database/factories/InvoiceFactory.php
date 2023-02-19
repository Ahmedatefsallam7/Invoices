<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'invoice_number' => fake()->numberBetween(1,10000),
            'user' => fake()->name(),
            'invoice_date' => fake()->date(),
            'due_date' => fake()->date(),
            'product' => fake()->name(),
            'section' => fake()->name(),
            'discount' => fake()->numberBetween(1,100).'%',
            'rate_vat' => fake()->numberBetween(1,100)."%",
            'value_vat' => fake()->randomFloat(2,1,100),
            'total' => fake()->randomFloat(2,1,100),
            'status' => fake()->randomElement([1,2,3]),
            'value_status' =>  fake()->randomNumber(),
            'note' =>fake()->text(),
            
            

        ];
    }
}