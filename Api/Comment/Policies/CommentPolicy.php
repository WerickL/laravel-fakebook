<?php

namespace Api\Comment\Policies;

use Api\User\Model\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function updateComment(User $user, $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
