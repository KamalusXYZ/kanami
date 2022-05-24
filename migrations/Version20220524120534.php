<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220524120534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment ADD toylibrary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB73FE63E FOREIGN KEY (toylibrary_id) REFERENCES toy_library (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DB73FE63E ON payment (toylibrary_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DB73FE63E');
        $this->addSql('DROP INDEX IDX_6D28840DB73FE63E ON payment');
        $this->addSql('ALTER TABLE payment DROP toylibrary_id');
    }
}
