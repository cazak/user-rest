<?php

declare(strict_types=1);

namespace App\User\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class Email
{
    public function __construct(
        #[ORM\Column]
        private string $value,
    ) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid email address.', $value));
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equalTo(self $other): bool
    {
        return $this->value === $other->value;
    }
}
