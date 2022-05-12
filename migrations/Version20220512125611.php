<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512125611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE toy_library (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, address VARCHAR(45) DEFAULT NULL, zip_code VARCHAR(10) DEFAULT NULL, city VARCHAR(45) DEFAULT NULL, country VARCHAR(45) DEFAULT NULL, legal_status VARCHAR(45) DEFAULT NULL, max_duration_loan_day INT NOT NULL, subscription_type VARCHAR(45) NOT NULL, subscription_price_month NUMERIC(8, 2) DEFAULT NULL, token_earn_month INT DEFAULT NULL, cost_money_load NUMERIC(8, 2) DEFAULT NULL, deposit_amount NUMERIC(8, 2) DEFAULT NULL, cost_money_loan NUMERIC(8, 2) DEFAULT NULL, deposit_is_cashable TINYINT(1) NOT NULL, late_cost_by_day NUMERIC(8, 2) DEFAULT NULL, max_loan_simult_user INT NOT NULL, max_loan_simult_family INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE toy_library');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
