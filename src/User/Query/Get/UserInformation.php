<?php

namespace App\User\Query\Get;

final readonly class UserInformation
{
    public function __construct(
        public string $id,
        public string $email,
        public string $role,
        public string $name,
        public string $surname,
    ) {}
}
