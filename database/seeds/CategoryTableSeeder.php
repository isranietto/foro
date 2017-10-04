<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Foro\Category::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);
        \Foro\Category::create([
            'name' => 'PHP',
            'slug' => 'php',
        ]);
        \Foro\Category::create([
            'name' => 'Vue.js',
            'slug' => 'vue-js',
        ]);
        \Foro\Category::create([
            'name' => 'CSS',
            'slug' => 'css',
        ]);
        \Foro\Category::create([
            'name' => 'SASS',
            'slug' => 'sass',
        ]);
        \Foro\Category::create([
            'name' => 'Git',
            'slug' => 'git',
        ]);
        \Foro\Category::create([
            'name' => 'Otras tecnologías',
            'slug' => 'otras-tecnologias',
        ]);
    }
}
