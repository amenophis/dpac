<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201010135403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users (
            id VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            registered_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE farms (
            id VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            user_id VARCHAR(255) NOT NULL,
            registered_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('COMMENT ON COLUMN users.registered_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN farms.registered_on IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE farms');
        $this->addSql('DROP TABLE users');
    }
}
