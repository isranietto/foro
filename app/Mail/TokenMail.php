<?php

namespace Foro\Mail;

use Foro\Token;
use Foro\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TokenMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Token
     */
    public $token;

    /**
     * TokenMail constructor.
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
