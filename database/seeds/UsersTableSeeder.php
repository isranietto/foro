<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Foro\User::class)->create([
            'name' => 'IsraNieto',
            'email' => 'isra@email.com',
        ]);
        factory(\Foro\User::class, 15)->create();

    }
}
