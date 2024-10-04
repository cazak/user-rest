<?php

declare(strict_types=1);

namespace App\User\Command\Create;

use App\Security\PasswordHasherInterface;
use App\User\Entity\User;
use App\User\Entity\UserRepository;
use App\User\Entity\ValueObject\Email;
use App\User\Entity\ValueObject\Name;
use App\User\Entity\ValueObject\Role;
use Symfony\Component\Uid\UuidV7;

final readonly class CreateUserCommandHandler
{
    public function __construct(
        private PasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository,
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User(
            new UuidV7(),
            new Email($command->email),
            new Name($command->name, $command->surname),
            Role::from($command->role),
            $this->passwordHasher->hash($command->plainPassword),
        );

        $this->userRepository->save($user);
    }
}
