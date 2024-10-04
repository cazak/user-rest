<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241004051250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add `user` table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user` (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
                role VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                email_value VARCHAR(255) NOT NULL,
                name_name VARCHAR(255) NOT NULL,
                name_surname VARCHAR(255) NOT NULL,
                UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email_value),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `user`');
    }
}
