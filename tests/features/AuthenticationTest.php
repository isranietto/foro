<?php

use Carbon\Carbon;
use Foro\Token;
use Illuminate\Support\Facades\Auth;

class AuthenticationTest extends FeatureTestCase
{
    /** @test */
    function test_a_user_can_login_with_a_token_url()
    {
        // Having
        $user =  $this->defaultUser();

        $token = Token::generateFor($user);

        // When
        $this->visit("login/{$token->token}");

        // Then
        $this->seeIsAuthenticated()
            ->seeIsAuthenticatedAs($user);

        $this->dontSeeInDatabase('tokens',[
            'id' => $token->id
        ]);

        $this->seePageIs('/');
    }

    /** @test */
    function test_a_user_can_login_with_an_invalid_token()
    {
        // Having
        $user =  $this->defaultUser();

        $token = Token::generateFor($user);

        $invalidToken = str_random(60);

        // When
        $this->visit("login/{$invalidToken}");

        // Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite otro');

        $this->seeInDatabase('tokens',[
            'id' => $token->id,
        ]);
    }

    /** @test */
    function test_a_user_cannot_use_the_same_toke_twice()
    {
        // Having
        $user =  $this->defaultUser();

        $token = Token::generateFor($user);

        $token->login();

        Auth::logout();

        // When
        $this->visit("login/{$token->token}");

        // Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite otro');

    }

    /** @test */
    function test__the_token_expires_after_30_minutes()
    {
        // Having
        $user =  $this->defaultUser();

        $token = Token::generateFor($user);

        // Hacemos que el tiempo transcurra por 31 minutos
        Carbon::setTestNow(Carbon::parse('+31 minutes'));

        // When
        $this->visit("login/{$token->token}");

        // Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite otro');

    }

    /** @test */
    function test_the_token_is_case_sensitive()
    {
        // Having
        $user =  $this->defaultUser();

        $token = Token::generateFor($user);

        // When
        $this->visitRoute("login",['token'=> strtolower($token->token)]);

        // Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite otro');

    }
}
