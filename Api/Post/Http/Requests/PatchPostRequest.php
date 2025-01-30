<?php 
namespace Api\Post\Http\Requests;

use Api\Post\Model\PostDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PatchPostRequest extends PostRequest
{
    public function authorize() :bool
    {
        // precisa estar logado, criar política
        if(Auth::check()){
            return true;
        }
        return false;
    }
    public function rules(): void
    {
    }
    
}