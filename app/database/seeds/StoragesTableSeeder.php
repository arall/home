<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class StoragesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        Storage::truncate();
        DB::table('item_storage')->truncate();

        foreach (range(1, 2) as $index) {
            $storage = Storage::create([
                'user_id' => 2,
                'name' => $faker->lastName(),
            ]);
            foreach (range(1, $faker->numberBetween(2, 10)) as $i) {
                $quantity = $faker->randomElement(array(-2, -1, 1, 2, 3, 4, 5));
                $storage->items()->attach($faker->numberBetween(1, 10), array(
                    'price' => ($quantity > 0) ? $faker->randomFloat(2, 1, 10) : null,
                    'quantity' => $quantity,
                ));
            }
        }
    }

}
