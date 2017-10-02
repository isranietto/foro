<?php

namespace Foro\Http\Controllers;

use Foro\{Token,User};
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        $user = User::create($request->all());

        Token::generateFor($user)->sendByEmail();

        return redirect(route('register_confirmation'));
    }

    public function confirmation()
    {
        return view('register.confirmation');
    }
}
