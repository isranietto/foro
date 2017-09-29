<?php


use Foro\Notifications\PostCommented;
use Illuminate\Support\Facades\Notification;

class NotifyUsersTest extends FeatureTestCase
{
    /** @test **/
    function test_the_subscribers_receive_a_notifications_when_post_is_commented()
    {
        Notification::fake();// este método hace la comprobación en memoria
        $post = $this->createPost();

        $subscriber =  factory(\Foro\User::class)->create();

        $subscriber->subscribeTo($post);

        $writer = factory(\Foro\User::class)->create();
        $writer->subscribeTo($post);

        $comment = $writer->comment($post, 'Un comentario cualquiera');

        Notification::assertSentTo(
            $subscriber, PostCommented::class, function ($notification) use ($comment) {
                return $notification->comment->id == $comment->id;
            }
        );

        // The author of the post comment shouldn't be notified even if he or she is a subscriber
        Notification::assertNotSentTo($writer, PostCommented::class);
    }
}
