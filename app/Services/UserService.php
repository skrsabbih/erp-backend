<?php
namespace App\Services;

use App\Enums\UserStatus;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository){}

    // first get paginated all users
    public function getUsers(int $perPage = 10, array $filters = [])
    {
        return $this->userRepository->paginate($perPage, $filters);
    }

    // find user by id
    public function findUser(int $id)
    {
        return $this->userRepository->find($id);
    }

    // create a new user
    public function createUser(array $data)
    {
        $data['status'] = UserStatus::ACTIVE;
        return $this->userRepository->create($data);
    }

    // update user by id
    public function updateUser(int $id, array $data)
    {
        // if password is not provided, do not update password
        if(empty($data['password'])){
            unset($data['password']);
        }

        $this->userRepository->update($id, $data);

        // return updated user
        return $this->userRepository->find($id);
    }

    // delete user by id
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    // active user by id
    public function activeUser(int $id)
    {
        $this->userRepository->update($id, ['status' => UserStatus::ACTIVE]);
        return $this->userRepository->find($id);
    }

    // deactive user by id
    public function deactiveUser(int $id)
    {
        $this->userRepository->update($id, ['status' => UserStatus::INACTIVE]);
        return $this->userRepository->find($id);
    }

}
