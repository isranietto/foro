<?php

namespace Foro\Http\Controllers;


use Foro\Token;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login($token)
    {
        $token = Token::findActive($token);

        if ($token == null){
            alert('Este enlace ya expiró, por favor solicite otro', 'danger');
            return redirect()->route('token');
        }

        $token->login();

        return redirect('/');
    }
}
