<?php

use Foro\{
    Comment, Post, User
};
use Foro\Notifications\PostCommented;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostCommentedTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    function it_builds_a_mail_message()
    {
        // Esta prueba la ejecutamos de manera mas rápida utilizando Eloquent
        //
        $post =  new Post([
            'title' => 'Titulo del post'
        ]);

        $writer =  new User([
            'first_name' => 'Israel',
            'last_name' => 'Nieto'
        ]);

        $comment = new Comment();
        $comment->post = $post;
        $comment->user = $writer;

        $notification = new PostCommented($comment);

        $subscriber = new User();

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            'Nuevo comentario en: Titulo del post',
            $message->subject
        );

        $this->assertSame(
            'Israel Nieto escribió un comentario en: Titulo del post',
            $message->introLines[0]
        );
        $this->assertSame($comment->post->url, $message->actionUrl);
    }
}
