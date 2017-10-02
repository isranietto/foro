<?php

use Foro\Token;
use Foro\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
    /** @test */
    function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->visitRoute('register')
            ->type('admin@isra.com', 'email')
            ->type('isratl', 'username')
            ->type('Isra', 'first_name')
            ->type('Nieto', 'last_name')
            ->press('Regístrate');

        $this->seeInDatabase('users',[
            'email' => 'admin@isra.com',
            'username' => 'isratl',
            'first_name' => 'Isra',
            'last_name' => 'Nieto'
        ]);

        $user = \Foro\User::first();

        $this->seeInDatabase('tokens', [
            'user_id' => $user->id,
        ]);

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id == $token->id;
        });

        $this->see('Enviamos a tu email un enlace para que inicies sesión');
    }
    
    /** @test */
    function test_form_register_validation()
    {
        $this->visitRoute('register')
            ->type('', 'email')
            ->type('', 'username')
            ->type('', 'first_name')
            ->type('', 'last_name')
            ->press('Regístrate')
            ->see('El campo correo electrónico es obligatorio')
            ->see('El campo usuario es obligatorio')
            ->see('El campo nombre es obligatorio')
            ->see('El campo apellido es obligatorio');
    }
}
