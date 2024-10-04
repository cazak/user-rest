<?php

namespace App\User\Validator\UniqueEmail;

use App\User\Entity\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UniqueEmailValidator extends ConstraintValidator
{
    public function __construct(private UserRepository $userRepository) {}

    /**
     * @param UniqueEmail $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $existingUser = $this->userRepository->findByEmail($value);

        if ($existingUser) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}
