<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Faker\Provider as FakerProvider;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('items')->truncate();
        DB::table('ingredient_item')->truncate();

        $faker = Faker::create();
        $faker->addProvider(new FakerProvider\Barcode($faker));
        $faker->addProvider(new FakerProvider\Lorem($faker));

        foreach (range(1, 10) as $index) {
            $item = Item::create([
                'type_id' => $faker->numberBetween(1, 10),
                'barcode' => $faker->ean13(),
                'name' => $faker->lastName(),
                'kcal' => $faker->numberBetween(10, 200),
                'quantity' => $faker->numberBetween(100, 500),
            ]);
            foreach (range(1, $faker->numberBetween(2, 10)) as $i) {
                $item->ingredients()->attach($faker->numberBetween(1, 10));
            }
        }
    }

}
