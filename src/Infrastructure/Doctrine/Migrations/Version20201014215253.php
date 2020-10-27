<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014215253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD activation_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD activated_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN users.activated_on IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP password');
        $this->addSql('ALTER TABLE users DROP activation_token');
        $this->addSql('ALTER TABLE users DROP activated_on');
    }
}
