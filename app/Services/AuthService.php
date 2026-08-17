<?php

namespace App\Services;

use App\Enums\UserStatus;
use App\Repositories\Interfaces\UserRepositoryInterface;

class AuthService
{
    public function __construct(protected UserRepositoryInterface $userRepository){}

    // this service layer for hande the business logic for authentication

    // handle the register business logic
    public function register(array $data): array
    {
        // default status added
        $data['status'] = UserStatus::ACTIVE;
        // use the user repository to create a new user
        $user = $this->userRepository->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        // return user
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    // handle the login business logic
    public function login(array $data): array
    {
        // find the user by email
        $user = $this->userRepository->findByEmail($data['email']);

        // check if user exists and password is correct
        if(!$user || !password_verify($data['password'], $user->password)){
            throw new \Exception('Invalid credentials');
        }
        // check if user is active or not
        if($user->status !== UserStatus::ACTIVE){
            throw new \Exception('User is not active');
        }

        // token generation
        $token = $user->createToken('auth_token')->plainTextToken;

        // return user
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    // handle the logout business logic
    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
