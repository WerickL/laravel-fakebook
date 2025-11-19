<?php

namespace Api\Comment\Model;

use Api\Like\Model\Like;
use Api\Post\Model\Post;
use Api\User\Model\User;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_comment_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id')->with('comments');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    protected static function newFactory(): Factory
    {
        return CommentFactory::new();
    }
}
