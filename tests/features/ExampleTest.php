<?php


class ExampleTest extends FeatureTestCase
{
    function test_basic_examples()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Israel Nieto',
            'email' => 'isra@mail.com'
        ]);
        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see('Israel Nieto')
            ->see('isra@mail.com');
    }
}
