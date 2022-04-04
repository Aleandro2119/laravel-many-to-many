<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [
            ['label' => 'HTML', 'color' => 'warning'],
            ['label' => 'CSS', 'color' => 'primary'],
            ['label' => 'JS ES6', 'color' => 'danger'],
            ['label' => 'VueJS', 'color' => 'success'],
            ['label' => 'PHP', 'color' => 'info'],
            ['label' => 'SQL', 'color' => 'secondary'],
            ['label' => 'Laravel', 'color' => 'muted'],
        ];
        foreach ($categories as $category) {
            $c = new Category();
            $c->label = $category['label'];
            $c->color = $category['color'];
            $c->save();
        }
    }
}
