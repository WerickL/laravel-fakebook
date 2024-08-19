<?php

namespace App\Http\Controllers\Auth;

use Api\User\Http\Requests\CreateUserRequest;
use App\Http\Controllers\Controller;
use Api\User\Model\User;
use Api\User\Repository\IUserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Api\User\Model\UserDto;

class RegisteredUserController extends Controller
{
    public function __construct(protected IUserRepository $repository )
    { 

    }
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(CreateUserRequest $request): RedirectResponse
    { 

        $user = $this->repository->create($request->toDto());
        Auth::login($user);
        
        return redirect(route('dashboard', absolute: false));
    }
}
