<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512141143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, register_date DATE NOT NULL, max_loan_simultaneous INT NOT NULL, delay_warning TINYINT(1) NOT NULL, delay_warning_nb INT DEFAULT NULL, incomplete_return TINYINT(1) NOT NULL, incomplete_return_nb INT DEFAULT NULL, blocked TINYINT(1) NOT NULL, payment_ok TINYINT(1) NOT NULL, token_available INT DEFAULT NULL, deposit TINYINT(1) NOT NULL, deposit_information VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payment_date DATETIME NOT NULL, payment_kind VARCHAR(45) NOT NULL, payment_amount NUMERIC(8, 2) NOT NULL, payment_comment VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE payment');
    }
}
