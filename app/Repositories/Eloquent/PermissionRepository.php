<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function __construct(protected Permission $model){}

    public function all()
    {
        return $this->model->orderBy('name')->get();
    }

}
