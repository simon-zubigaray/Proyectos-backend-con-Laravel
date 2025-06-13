<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\TaskStatus;
use Faker\Factory as Faker;

use function PHPUnit\Framework\isEmpty;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $usersId = DB::table('users')->pluck('id')->toArray();

        if(empty($usersId)){
            $this->command->warn('No hay usuarios en esta tabla.');
            return;
        }

        $tasks = [];

        for($i = 1; $i < 30; $i++){
            $tasks[] = [
                'title' => $faker->word(),
                'description' => $faker->sentence(),
                'status' => $faker->randomElement([
                        TaskStatus::PENDING->value, 
                        TaskStatus::COMPLETED->value, 
                        TaskStatus::CANCELED->value
                    ]),
                'user_id' => $faker->randomElement($usersId),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('task')->insert($tasks);
    }
}