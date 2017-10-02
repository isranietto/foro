<?php

namespace Foro;

use Foro\Notifications\PostCommented;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email','username','first_name','last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Post::class, 'subscriptions');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function createPost(array $data)
    {
        $post = new Post($data);
        $this->posts()->save($post);
        $this->subscribeTo($post);

        return $post;
    }

    public function subscribeTo(Post $post)
    {
        $this->subscriptions()->attach($post);
    }
    public function unSubscribeFrom(Post $post)
    {
        $this->subscriptions()->detach($post);
    }

    public function comment(Post $post, $comment)
    {
        $comment  =  new Comment([
            'comment' => $comment,
            'post_id' => $post->id,
        ]);

        $this->comments()->save($comment);

        //Notify subscribers
        Notification::send(
            $post->subscribers()->where('users.id','!=', $this->id)->get(),
            new PostCommented($comment)
        );

        return $comment;
    }

    public function isSubscribeTo(Post $post)
    {
        // valida si el usuario esta suscrito al post que estamos viendo
        return $this->subscriptions()->where('post_id', $post->id)->count() > 0;
    }
    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
