<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(protected Role $model){}

    public function all()
    {
        return $this->model->with('permissions')->all();
    }

    public function find(int $id)
    {
        return $this->model->with('permissions')->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function syncPermissions(int $id, array $permissions)
    {
        return $this->model->find($id)->syncPermissions($permissions);
    }
}
