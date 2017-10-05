<?php

use Foro\Category;
use Foro\User;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =  $users =  User::select('id')->get();
        $categories = Category::select('id')->get();

        for ($i = 0; $i < 250; ++$i) {
            factory(\Foro\Post::class)->create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'created_at' => \Carbon\Carbon::now()->subHour(rand(0 ,720))
            ]);
        }
    }
}
