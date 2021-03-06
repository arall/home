<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        Ingredient::truncate();

        foreach (range(1, 10) as $index) {
            Ingredient::create([
                'name' => $faker->lastName(),
            ]);
        }
    }

}
