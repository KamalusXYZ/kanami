<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523125143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE relationship ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE relationship ADD CONSTRAINT FK_200444A07597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_200444A07597D3FE ON relationship (member_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE relationship DROP FOREIGN KEY FK_200444A07597D3FE');
        $this->addSql('DROP INDEX IDX_200444A07597D3FE ON relationship');
        $this->addSql('ALTER TABLE relationship DROP member_id');
    }
}
