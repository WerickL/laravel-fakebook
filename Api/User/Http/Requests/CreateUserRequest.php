<?php
namespace Api\User\Http\Requests;
use Api\User\Model\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules;
use Api\User\Model\UserDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules():array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            "username" =>  'required|string|lowercase|max:255|unique:'.User::class
        ];
    }
    
    public function toDto(): UserDto
    {
        return new UserDto(
            name: $this->input("name"),
            email: $this->input("email"),
            password: $this->input("password"),
            username: $this->input("username")
        );
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}