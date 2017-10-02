<?php


use Foro\Token;
use Foro\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;

class AuthenticationTest extends FeatureTestCase
{
    /** @test */
    function test_a_guest_user_can_request_a_token()
    {
        // Havin
        Mail::fake();

        $user = $this->defaultUser(['email' => 'admin@isra.net']);

        // When

        $this->visitRoute('login')
            ->type('admin@isra.net', 'email')
            ->press('Solicitar token');

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token, 'A token was not created');

        Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->see('Enviamos a tu email un enlace para que inicies sesión');

    }
    /** @test */
    function test_a_guest_user_can_request_a_token_without_an_email()
    {
        // Havin
        Mail::fake();

        // When
        $this->visitRoute('login')
            ->type('', 'email')
            ->press('Solicitar token');

        // Then: a new token is NOT created in the database
        $token = Token::first();

        $this->assertNull($token, 'A token was not created');

        Mail::assertNotSent(TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors([
            'email' => 'El campo correo electrónico es obligatorio'
        ]);
    }

    /** @test */
    function test_a_guest_user_can_request_a_token_an_invalid_email()
    {
        $this->visitRoute('login')
            ->type('isra', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Correo electrónico no es un correo válido'
        ]);

    }

    /** @test */
        function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
    {
        $this->defaultUser(['email' => 'admin@isra.net']);

        $this->visitRoute('login')
            ->type('i@isra.net', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Este correo electrónico no existe'
        ]);

    }
}
