<?php

namespace Database\Factories;

use App\Models\Record;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Record>
 */
class RecordFactory extends Factory
{
    protected $model = Record::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->unique()->name(),
            'extension' => $this->faker->randomElement(['mp3']),
            'mime' => $this->faker->randomElement(['audio/mp3', 'audio/mpeg']),
            'hash' => $this->faker->sha256(),
        ];
    }
}
