<?php

namespace Foro;

use Carbon\Carbon;
use Foro\Mail\TokenMail;
use Illuminate\Support\Facades\Auth;
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

    public static function findActive($token)
    {
        return static::where('token', $token)
            // comprobamos que no halla pasado 30 minutos
            ->where('created_at' ,'>=' , Carbon::parse('-30 minutes'))
            ->first();
    }

    public function sendByEmail()
    {
        Mail::to($this->user)->send(new TokenMail($this));
    }

    public function login()
    {
        Auth::login($this->user, true);

        $this->delete();
    }

    public function getUrlAttribute()
    {
        return route('login', ['token' => $this->token]);
    }
}
