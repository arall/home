<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ItemTypesTableSeeder extends Seeder
{
    public function run()
    {

        DB::table('item_types')->truncate();

        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            ItemType::create([
                'name' => $faker->lastName(),
            ]);
        }
    }

}
