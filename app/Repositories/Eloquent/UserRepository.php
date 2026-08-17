<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $model){}
    // oop solid interface rule now use the contract here
    public function all()
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 10, array $filters = [])
    {
        $query = $this->model->query()->with('roles');
        // serch for the user filter
        if(!empty($filters['search'])){
            $query->where(function ($q) use ($filters){
                $q->where('name', 'like', "%{$filters['search']}%")
                ->orwhere('email', 'like', "%{$filters['search']}%");
            });
        }
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
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
}

