<?php

namespace App\RepositoryInterface;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(string $name, string $email, string $password): ?User;
}
