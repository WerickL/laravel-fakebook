<?php 
namespace Api\User\Http\Controllers;

use Api\User\Http\Requests\CreateUserRequest;
use Api\User\Http\Requests\PatchUserRequest;
use Api\User\Model\User;
use Api\User\Repository\IUserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct(protected IUserRepository $repository )
    {  
    }
    
    public function postUser(CreateUserRequest $request): JsonResponse
    {
        $user = $this->repository->create($request->toDto());
        return response()->json($user, 201);
    }
    public function patchUser(PatchUserRequest $request, string $id): JsonResponse
    {
        $model = $this->repository->find($id);
        Gate::authorize("update", $model);
        $user = $this->repository->patch($request->user(), $request->toDto());
        return response()->json($user, 200);
    }
    public function followUser(PatchUserRequest $request, string $id)
    {
        $model = $this->repository->find($id);
        Gate::authorize("follow", $model);
        $sucess = false;
        if (count($request->user()->following()->wherePivot("followed_user_id", $model->id)->get()) == 0) {
            $sucess = $this->repository->follow($request->user(), $model);
        }
        
        if ($sucess) {
            return response()->json(["message"=>"User followed successfully"],200);
        }else{
            return response()->json([
                "message" => "User followed unsuccessfully"
            ],400);
        }
    }
}