<?php

namespace App\User\Validator\OwnOrUniqueField;

use Symfony\Component\Validator\Constraint;

final class OwnOrUniqueFieldContext extends Constraint
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
        parent::__construct();
    }
}
