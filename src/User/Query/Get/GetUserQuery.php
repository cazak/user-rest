<?php

declare(strict_types=1);

namespace App\User\Query\Get;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetUserQuery
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $id,
    ) {}
}
