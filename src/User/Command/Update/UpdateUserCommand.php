<?php

declare(strict_types=1);

namespace App\User\Command\Update;

use App\User\Entity\ValueObject\Role;
use App\User\Validator\OwnOrUniqueField\OwnOrUniqueField;
use App\User\Validator\OwnOrUniqueField\OwnOrUniqueFieldContext;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateUserCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $id,
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
    ) {}

    #[OwnOrUniqueField(
        fieldName: 'email.value',
        propertyPath: 'email',
    )]
    public function hasOwnOrUniqueEmail(): OwnOrUniqueFieldContext
    {
        return new OwnOrUniqueFieldContext($this->id, $this->email);
    }
}
