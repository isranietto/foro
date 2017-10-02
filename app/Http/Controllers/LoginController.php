<?php

namespace Foro\Http\Controllers;

use Foro\Token;
use Foro\User;
use Illuminate\Http\Request;
use Styde\Html\Facades\Alert;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|exists:users'
        ]);
        $user = User::where('email', $request->get('email'))->first();

        Token::generateFor($user)->sendByEmail();

        \alert('Enviamos a tu email un enlace para que inicies sesión');

        return back();

    }
}
