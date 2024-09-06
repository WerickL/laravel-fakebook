<?php
namespace Api\User\Http\Requests;
use Api\User\Model\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules;
use Api\User\Model\UserDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class PatchUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        if(Auth::check()){
            return true;
        }
        return false;
    }
    public function rules():array
    {
        return [];
    }
    
    public function toDto(): UserDto
    {
        return new UserDto(
            name: $this->input("name"),
            email: $this->input("email"),
            username: $this->input("username")
        );
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}