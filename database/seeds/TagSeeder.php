<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $labels = [
            'FrontEnd', 'BackEnd', 'FullStack', 'SPA', 'Designer'
        ];

        foreach ($labels as $label) {
            $t = new Tag();
            $t->label = $label;
            $t->color = $label['color'];
            $t->save();
        }
    }
}
