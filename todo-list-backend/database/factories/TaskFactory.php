<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\TaskStatus;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
                'title' => $this->faker->word(),
                'description' => $this->faker->sentence(),
                'status' => $this->faker->randomElement([TaskStatus::PENDING, TaskStatus::COMPLETED, TaskStatus::CANCELED]),
                'user_id' => User::factory()
        ];
    }
}