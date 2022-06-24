<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620195544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family CHANGE incomplete_return incomplete_return TINYINT(1) NOT NULL, CHANGE blocked blocked TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE loan CHANGE item_id item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('CREATE INDEX IDX_C5D30D03126F525E ON loan (item_id)');
        $this->addSql('ALTER TABLE payment CHANGE payment_amount payment_amount NUMERIC(8, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family CHANGE incomplete_return incomplete_return TINYINT(1) DEFAULT NULL, CHANGE blocked blocked TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03126F525E');
        $this->addSql('DROP INDEX IDX_C5D30D03126F525E ON loan');
        $this->addSql('ALTER TABLE loan CHANGE item_id item_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment CHANGE payment_amount payment_amount NUMERIC(8, 2) NOT NULL');
    }
}
