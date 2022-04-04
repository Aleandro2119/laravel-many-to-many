<?php

use App\Models\Tag;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //

        $labels = [
            'FrontEnd', 'BackEnd', 'FullStack', 'SPA', 'Designer'
        ];

        foreach ($labels as $label) {
            $t = new Tag();
            $t->label = $label;
            $t->color = $faker->safeHexColor();
            $t->save();
        }
    }
}
