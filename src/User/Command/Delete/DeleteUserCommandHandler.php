<?php

declare(strict_types=1);

namespace App\User\Command\Delete;

use App\User\Entity\User;
use App\User\Entity\UserRepository;
use App\User\Entity\ValueObject\Email;
use App\User\Entity\ValueObject\Name;
use App\User\Entity\ValueObject\Role;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteUserCommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {}

    public function __invoke(DeleteUserCommand $command): void
    {
        $user = $this->userRepository->findById($command->id);

        if ($user === null) {
            throw new EntityNotFoundException('User not found');
        }

        $this->userRepository->delete($user);
    }
}
