<?php
namespace App\Services\Repository;
use App\Models\User;
use App\Services\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * create User
     * @param array $data
     *
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * attemptLogin
     * @param array $credentials
     *
     * @return string|null
     */
    public function attemptLogin(array $credentials): ?string
    {
        if (!$token = auth()->attempt($credentials)) {
            return null;
        }

        return $token;
    }
}
