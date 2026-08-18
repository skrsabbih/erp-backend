<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // call the service layer first
    public function __construct(protected PermissionService $permissionService){}

    // handle the all permissions request
    public function index(): JsonResponse
    {
        $permissions = $this->permissionService->getAllPermissions();

        // return success response
        return response()->json([
            'message' => 'Permission List Successfully',
            'data'    => PermissionResource::collection($permissions),
        ]);
    }

}
