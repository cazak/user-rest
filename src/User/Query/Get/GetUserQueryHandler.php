<?php

declare(strict_types=1);

namespace App\User\Query\Get;

use App\User\Entity\UserRepository;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetUserQueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {}

    public function __invoke(GetUserQuery $query): UserInformation
    {
        $user = $this->userRepository->findById($query->id);

        if ($user === null) {
            throw new EntityNotFoundException('User not found');
        }

        return new UserInformation(
            id: $query->id,
            email: $user->getEmail()->getValue(),
            role: $user->getRole()->value,
            name: $user->getName()->getName(),
            surname: $user->getName()->getSurname(),
        );
    }
}
