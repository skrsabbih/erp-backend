<?php
namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService
{
    public function __construct(protected PermissionRepositoryInterface $permissionRepository){}

    // handle the permissions business logic
    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }
}
