<?php

namespace App\User\Validator\OwnOrUniqueField;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(
    Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE
)]
final class OwnOrUniqueField extends Constraint
{
    public function __construct(
        public string $propertyPath,
        public string $fieldName,
        public string $message = 'The field in not owned.',
    ) {
        parent::__construct();
    }
}
