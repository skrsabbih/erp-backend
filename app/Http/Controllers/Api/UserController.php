<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // call the service layer first
    public function __construct(protected UserService $userService)
    {}

    // for get the all user request
    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getUsers($request->integer('per_page', 10), $request->all());

        return response()->json([
            'message' => 'User List Successfully',
            'data'    => UserResource::collection(($users)),
        ]);
    }

    // store a new user request
    public function store(StoreUserRequest $request): JsonResponse
    {
        // user validation and create user
        $validation = $request->validated();
        $user       = $this->userService->createUser($validation);

        // return success response
        return response()->json([
            'message' => 'User created successfully',
            'user'    => new UserResource($user),
        ], 201);
    }

    // single user request
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->findUser($id);

        if (! $user) {
            return response()->json([
                'message' => 'User Not Found',
            ], 404);
        }

        return response()->json([
            'message' => 'User Detail Successfully',
            'user'    => new UserResource($user),
        ]);
    }

    // update user request
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        // user validation and update user
        $validation = $request->validated();
        $user       = $this->userService->updateUser($id, $validation);

        if (! $user) {
            return response()->json([
                'message' => 'User Not Found',
            ], 404);
        }

        // return success response
        return response()->json([
            'message' => 'User updated successfully',
            'user'    => new UserResource($user),
        ], 201);
    }

    // delete user request
    public function delete(int $id): JsonResponse
    {
        $user = $this->userService->findUser($id);

        if (! $user) {
            return response()->json([
                'message' => 'User Not Found',
            ], 404);
        }

        $this->userService->deleteUser($id);

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    // active user request
    public function active(int $id): JsonResponse
    {
        $user = $this->userService->activeUser($id);

        if (! $user) {
            return response()->json([
                'message' => 'User Not Found',
            ], 404);
        }

        return response()->json([
            'message' => 'User active successfully',
            'user'    => new UserResource($user),
        ]);
    }

    // deactive user request
    public function deactive(int $id): JsonResponse
    {
        $user = $this->userService->deactiveUser($id);

        if (! $user) {
            return response()->json([
                'message' => 'User Not Found',
            ], 404);
        }

        return response()->json([
            'message' => 'User deactive successfully',
            'user'    => new UserResource($user),
        ]);
    }
}
