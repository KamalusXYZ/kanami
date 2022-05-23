<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523102600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan ADD family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_C5D30D03C35E566A ON loan (family_id)');
        $this->addSql('ALTER TABLE payment ADD family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DC35E566A ON payment (family_id)');
        $this->addSql('ALTER TABLE relationship ADD family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE relationship ADD CONSTRAINT FK_200444A0C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_200444A0C35E566A ON relationship (family_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03C35E566A');
        $this->addSql('DROP INDEX IDX_C5D30D03C35E566A ON loan');
        $this->addSql('ALTER TABLE loan DROP family_id');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DC35E566A');
        $this->addSql('DROP INDEX IDX_6D28840DC35E566A ON payment');
        $this->addSql('ALTER TABLE payment DROP family_id');
        $this->addSql('ALTER TABLE relationship DROP FOREIGN KEY FK_200444A0C35E566A');
        $this->addSql('DROP INDEX IDX_200444A0C35E566A ON relationship');
        $this->addSql('ALTER TABLE relationship DROP family_id');
    }
}
