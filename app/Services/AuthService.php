<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class AuthService
{
    public function __construct(protected UserRepositoryInterface $userRepository){}

    // this service layer for hande the business logic for authentication
    public function register(array $data)
    {
        // use the user repository to create a new user
        $user = $this->userRepository->create($data);

        // return user
        return $user;
    }
}
