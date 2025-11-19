<?php

namespace Api\Like\Http\Requests;

use Api\Like\Model\LikeDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostLikeRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "post_id" => [
                "nullable",
                "integer",
                Rule::exists('posts', 'id'),
                Rule::requiredIf(fn () => ! request('comment_id')),
                Rule::prohibitedIf(fn () => request('comment_id')),
            ],
            "comment_id" => [
                "nullable",
                "integer",
                Rule::exists('comments', 'id'),
                Rule::requiredIf(fn () => ! request('post_id')),
                Rule::prohibitedIf(fn () => request('post_id')),
            ],
        ];
    }
    public function toDto(){
        return new LikeDto(
            postId: $this->input('post_id'),
            commentId: $this->input('comment_id'),
            userId: Auth::id()
        );
    }
}
