<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test */
    public function test_a_user_can_logout()
    {
        $user = $this->defaultUser([
            'first_name' => 'Isra',
            'last_name' => 'Nieto'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->clickLink('Isra Nieto')
                    ->clickLink('Cerrar sesión')
                    ->assertGuest();
        });
    }
}
