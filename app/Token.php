<?php

namespace Foro;

use Foro\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'token';// remplasamos el id por
        // el campo toquen para crear una url
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateFor(User $user)
    {
        $token = new static();

        $token->token =  str_random(60);
        $token->user()->associate($user);
        $token->save();
        return $token;

        //se puede hacer de las dos formas
        // associate es un método de eloquent
        /*return static::create([
            'token' => str_random(60),
            'user_id' => $user->id,
        ]);*/
    }

    public function sendByEmail()
    {
        Mail::to($this->user)->send(new TokenMail($this));
    }
}
