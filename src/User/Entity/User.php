<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\User\Entity\ValueObject\Email;
use App\User\Entity\ValueObject\Name;
use App\User\Entity\ValueObject\Role;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/** @final */
#[ORM\Entity]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', columns: ['email_value'])]
class User
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    private readonly Uuid $id;

    #[ORM\Embedded]
    private Email $email;

    #[ORM\Embedded]
    private Name $name;

    #[ORM\Column]
    private Role $role;

    #[ORM\Column]
    private string $password;

    #[ORM\Column]
    private readonly DateTimeImmutable $createdAt;

    public function __construct(Uuid $id, Email $email, Name $name, Role $role, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->role = $role;
        $this->password = $password;
        $this->createdAt = new DateTimeImmutable();
    }

    public function update(Email $email, Name $name, Role $role): void
    {
        $this->email = $email;
        $this->name = $name;
        $this->role = $role;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
