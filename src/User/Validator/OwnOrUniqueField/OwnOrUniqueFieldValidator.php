<?php

namespace App\User\Validator\OwnOrUniqueField;

use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class OwnOrUniqueFieldValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function validate(mixed $context, Constraint $constraint): void
    {
        \assert($context instanceof OwnOrUniqueFieldContext);
        \assert($constraint instanceof OwnOrUniqueField);

        if ($context->value === null || $context->value === '') {
            return;
        }

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy([$constraint->fieldName => $context->value]);

        if ($existingUser !== null) {
            if ($existingUser->getId()->toString() !== $context->id) {
                $this->context->setNode($this->context->getValue(), $this->context->getObject(), $this->context->getMetadata(), $constraint->propertyPath);
                $this->context
                    ->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
