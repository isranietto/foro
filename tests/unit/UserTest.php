<?php


class UserTest extends FeatureTestCase
{
    /** @test */
    function test_a_user_owner_()
    {
        $user= factory(\Foro\User::class)->create(['id' => 1]);

        $post =  factory(\Foro\Post::class)->create([
            'user_id' => $user->id
        ]);

        $this->assertTrue($user->owns($post));
    }

    /** @test */
    function test_a_user_is_not_owner()
    {
        $not_owner= factory(\Foro\User::class)->create(['id' => 1]);
        $owner = factory(\Foro\User::class)->create(['id' => 2]);

        $post =  factory(\Foro\Post::class)->create([
            'user_id' => $owner->id
        ]);

        $this->assertFalse($not_owner->owns($post));
    }
}
