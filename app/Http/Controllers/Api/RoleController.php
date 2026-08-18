<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // call the service layer first
    public function __construct(protected RoleService $roleService){}

    // handle the all role request
    public function index(): JsonResponse
    {
        $roles = $this->roleService->getRoles();

        // return success response
        return response()->json([
            'message' => 'Role List Successfully',
            'data'    => RoleResource::collection($roles),
        ]);
    }

    // handle the find role request
    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->findRole($id);

        if(!$role){
            return response()->json([
                'message' => 'Role Not Found',
            ], 404);
        }

        // return success response
        return response()->json([
            'message' => 'Role Detail Successfully',
            'data'    => new RoleResource($role),
        ]);
    }

    // handle store role request
    public function store(StoreRoleRequest $request): JsonResponse
    {
        // role validation and create role
        $validation = $request->validated();
        $role       = $this->roleService->createRole($validation);

        // return success response
        return response()->json([
            'message' => 'Role Created Successfully',
            'data'    => new RoleResource($role),
        ], 201);
    }

    // handle update role request
    public function update(int $id, UpdateRoleRequest $request): JsonResponse
    {
        // role validation and update role
        $validation = $request->validated();
        $role       = $this->roleService->updateRole($id, $validation);

        if(!$role){
            return response()->json([
                'message' => 'Role Not Found',
            ], 404);
        }

        // return success response
        return response()->json([
            'message' => 'Role Updated Successfully',
            'data'    => new RoleResource($role),
        ], 201);
    }

    // handle delete role request
    public function destroy(int $id): JsonResponse
    {
        $role = $this->roleService->delete($id);

        if(!$role){
            return response()->json([
                'message' => 'Role Not Found',
            ], 404);
        }

        // return success response
        return response()->json([
            'message' => 'Role Deleted Successfully',
        ]);
    }

    // handle sync permissions request
    public function syncPermissions(UpdateRoleRequest $request, $id): JsonResponse
    {
        $validation = $request->validated();
        $role = $this->roleService->syncRoleWithPermissions($id, $validation['permissions']);

        // return success response
        return response()->json([
            'message' => 'Role Sync Permission Successfully',
            'data'    => new RoleResource($role),
        ], 200);
    }
}
