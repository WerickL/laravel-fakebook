<?php 
namespace Api\Post\Http\Requests;

use Api\Post\Model\PostDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePostRequest extends PostRequest
{
    public function authorize() :bool
    {
        // precisa estar logado, criar política
        if(Auth::check()){
            return true;
        }
        return false;
    }
    public function rules():array
    {
        return [
            "description"=>"required|string|max:255"
        ];
    }
}