<?php
namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleService
{
    public function __construct(protected RoleRepositoryInterface $roleRepository){}

    // handle the get all roles business logic
    public function getRoles()
    {
        return $this->roleRepository->all();
    }

    // handle the find role business logic
    public function findRole(int $id)
    {
        return $this->roleRepository->find($id);
    }

    // handle the create role business logic
    public function createRole(array $data)
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);
        $data['guard_name'] = 'web';

        $role = $this->roleRepository->create($data);
        if(!empty($permissions)){
            $role->syncPermissions($permissions);
        }

        return $role->load('permissions');
    }

    // handle the update role business logic
    public function updateRole(int $id, array $data)
    {
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = $this->roleRepository->update($id, $data);

        if(!$role){
            return null;
        }

        if($permissions !==null){
            $role->syncPermissions($permissions);
        }

        return $role->load('permissions');
    }

    // handle the delete role business logic
    public function delete(int $id)
    {
        return $this->roleRepository->delete($id);
    }

    // handle sync permissions business logic
    public function syncRoleWithPermissions(int $id, array $permissions)
    {
        return $this->roleRepository->syncPermissions($id, $permissions);
    }
}
