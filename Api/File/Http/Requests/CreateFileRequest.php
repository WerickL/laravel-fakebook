<?php
namespace Api\File\Http\Requests;

use Api\File\Model\FileDto;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateFileRequest extends FormRequest
{
    public function authorize() :bool
    {
        if(Auth::check()){
            return true;
        }
        return false;
    }
    public function rules(): array
    {
        return [
            "name"=>"required|string|max:255",
            'content' => 'required',
            "description"=>"nullable|string|max:255",
            "content_type"=>"required|string|max:255",
            "post_id"=>"nullable|exists:posts,id"
        ];
    }

    public function toDto(): FileDto
    {
        return FileDto::fromArray($this->only(['description', 'name', 'content_type']));
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}