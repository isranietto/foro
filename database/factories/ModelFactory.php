<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Foro\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(\Foro\Post::class, function (\Faker\Generator $faker){
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'pending' => true,
        'user_id' => function () {
            return factory(\Foro\User::class)->create()->id;
        }
    ];
});

$factory->define(\Foro\Comment::class, function (\Faker\Generator $faker){
    return [
        'comment' => $faker->paragraph,
        'post_id' => function () {
            return factory(\Foro\Post::class)->create()->id;
        },
        'user_id' => function () {
            return factory(\Foro\User::class)->create()->id;
        }
    ];
});
