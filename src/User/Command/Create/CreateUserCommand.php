<?php

declare(strict_types=1);

namespace App\User\Command\Create;

use App\User\Entity\ValueObject\Role;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUserCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [Role::class, 'casesAtString'], message: 'The duration type is not valid.')]
        public string $role,
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $surname,
        #[Assert\NotBlank]
        #[Assert\PasswordStrength(minScore: Assert\PasswordStrength::STRENGTH_WEAK)]
        public string $plainPassword,
    ) {}
}
