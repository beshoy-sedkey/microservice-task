<?php

namespace App\Services\Repository;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function attemptLogin(array $credentials): ?string;
}
