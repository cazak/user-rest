<?php

namespace App\User\Validator\UniqueEmail;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[\Attribute(
    Attribute::TARGET_PROPERTY
)]
final class UniqueEmail extends Constraint
{
    public string $message = 'The email "{{ value }}" is already in use.';
}
