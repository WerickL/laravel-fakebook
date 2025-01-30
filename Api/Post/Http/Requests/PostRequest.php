<?php 
namespace Api\Post\Http\Requests;

use Api\Post\Model\PostDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostRequest extends FormRequest
{
    public function toDto(){
        return new PostDto(
            description:$this->input("description"),
            user: $this->user()
        );
    }
}