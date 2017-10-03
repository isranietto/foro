<?php


use Foro\Mail\TokenMail;
use Foro\User;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class TokenMailTest extends FeatureTestCase
{
    /** @test */
    function it_sends_a_link_with_the_token()
    {
        $user = new User([
            'first_name' => 'Israel',
            'last_name' => 'Nieto',
            'email' => 'isra@mail.com',
        ]);

        $token =  new \Foro\Token([
            'token' => 'this-is-a-token',
            'user_id' => $user->id
        ]);

        $this->open(new TokenMail($token))
            ->seeLink($token->url, $token->url);
    }

    protected function open(\Illuminate\Mail\Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();

        Mail::send($mailable);

        $message = $transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());

        return $this;
    }
}
