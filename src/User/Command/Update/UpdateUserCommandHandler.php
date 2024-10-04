<?php

declare(strict_types=1);

namespace App\User\Command\Update;

use App\User\Entity\User;
use App\User\Entity\UserRepository;
use App\User\Entity\ValueObject\Email;
use App\User\Entity\ValueObject\Name;
use App\User\Entity\ValueObject\Role;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateUserCommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ) {}

    public function __invoke(UpdateUserCommand $command): void
    {
        $user = $this->userRepository->findById($command->id);

        if ($user === null) {
            throw new EntityNotFoundException();
        }

        $user->update(
            new Email($command->email),
            new Name($command->name, $command->surname),
            Role::from($command->role),
        );

        $this->userRepository->save($user);
    }
}
