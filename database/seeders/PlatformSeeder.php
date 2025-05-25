<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 3; $i++) {
            Platform::query()->create([
                "name" => $faker->company(),
                "type" => $i + 1,
            ]);
        }
    }
}
