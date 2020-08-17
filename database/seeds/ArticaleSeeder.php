<?php

use Illuminate\Database\Seeder;

class ArticaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =\Faker\Factory::create();
        for($i=0;$i<150;$i++){
            \App\Articales::create([
                'title' => $faker->text(120),
                'description' => $faker->text,
            ]);
        }
    }
}
