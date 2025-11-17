<?php

namespace Api\Comment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FetchCommentRequest extends CommentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::check()){
            return true;
        }
        return false;
    }
    public function rules()
    {
        return [
            'post_id' => ['nullable', 'integer', 'exists:posts,id']
        ];
    }
}
