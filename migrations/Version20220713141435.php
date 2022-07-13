<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713141435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_dependance (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, category_id INT DEFAULT NULL, INDEX IDX_9225CE63126F525E (item_id), INDEX IDX_9225CE6312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE daily_session (id INT AUTO_INCREMENT NOT NULL, start_date_time DATETIME DEFAULT NULL, end_date_time DATETIME DEFAULT NULL, session_comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, theme VARCHAR(45) DEFAULT NULL, start_date_time DATETIME NOT NULL, end_date_time DATETIME DEFAULT NULL, event_price VARCHAR(45) DEFAULT NULL, mandatory_booking TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_select_game (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, register_date DATE NOT NULL, max_loan_simultaneous INT NOT NULL, delay_warning TINYINT(1) NOT NULL, delay_warning_nb INT DEFAULT NULL, incomplete_return TINYINT(1) NOT NULL, incomplete_return_nb INT DEFAULT NULL, blocked TINYINT(1) NOT NULL, payment_ok TINYINT(1) NOT NULL, token_available INT DEFAULT NULL, deposit TINYINT(1) NOT NULL, deposit_information VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, start_date_time DATETIME NOT NULL, end_date_time DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ref VARCHAR(45) DEFAULT NULL, lang VARCHAR(45) DEFAULT NULL, publisher_game_duration VARCHAR(45) DEFAULT NULL, our_game_duration VARCHAR(45) DEFAULT NULL, player_nb_min INT DEFAULT NULL, player_nb_max INT DEFAULT NULL, age_min INT DEFAULT NULL, author VARCHAR(45) DEFAULT NULL, illustrator VARCHAR(45) DEFAULT NULL, publisher VARCHAR(45) DEFAULT NULL, item_condition VARCHAR(20) DEFAULT NULL, completeness TINYINT(1) DEFAULT NULL, available TINYINT(1) NOT NULL, archive TINYINT(1) NOT NULL, update_pseudo_user VARCHAR(45) DEFAULT NULL, update_date_time DATETIME DEFAULT NULL, archive_pseudo_user VARCHAR(45) DEFAULT NULL, archive_date_time DATETIME DEFAULT NULL, archive_cause VARCHAR(45) DEFAULT NULL, archive_game_become VARCHAR(45) DEFAULT NULL, member_item_rating_total NUMERIC(2, 1) DEFAULT NULL, member_item_rating_nb INT DEFAULT NULL, game_price NUMERIC(8, 2) DEFAULT NULL, game_origin VARCHAR(45) DEFAULT NULL, user_made_entry VARCHAR(45) DEFAULT NULL, copy_number INT DEFAULT NULL, register_date_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_tag (item_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E49CCCB1126F525E (item_id), INDEX IDX_E49CCCB1BAD26311 (tag_id), PRIMARY KEY(item_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_inventory (id INT AUTO_INCREMENT NOT NULL, is_checked TINYINT(1) DEFAULT NULL, who_checked VARCHAR(45) DEFAULT NULL, check_date_time DATETIME DEFAULT NULL, check_comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, family_id INT DEFAULT NULL, item_id INT DEFAULT NULL, start_date_time DATETIME NOT NULL, date_preview_back DATE NOT NULL, effect_return_date_time DATETIME DEFAULT NULL, completeness_return TINYINT(1) DEFAULT NULL, return_comment VARCHAR(255) DEFAULT NULL, INDEX IDX_C5D30D03C35E566A (family_id), INDEX IDX_C5D30D03126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, relation_ship_id INT DEFAULT NULL, member_event_id INT DEFAULT NULL, member_daily_session_id INT DEFAULT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, birthday DATE NOT NULL, phone VARCHAR(20) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(45) DEFAULT NULL, zip_code VARCHAR(45) DEFAULT NULL, city VARCHAR(45) DEFAULT NULL, country VARCHAR(45) DEFAULT NULL, other_address_detail VARCHAR(45) DEFAULT NULL, archive TINYINT(1) DEFAULT NULL, INDEX IDX_70E4FA78DB2D230C (relation_ship_id), INDEX IDX_70E4FA78862A4B61 (member_event_id), INDEX IDX_70E4FA78AC3B625A (member_daily_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_daily_session (id INT AUTO_INCREMENT NOT NULL, arrival_date_time DATETIME DEFAULT NULL, exit_date_time DATETIME DEFAULT NULL, member_comment VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_event (id INT AUTO_INCREMENT NOT NULL, arrival_date_time DATETIME DEFAULT NULL, exit_date_time DATETIME DEFAULT NULL, member_comment VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, family_id INT DEFAULT NULL, toylibrary_id INT DEFAULT NULL, payment_date DATETIME NOT NULL, payment_kind VARCHAR(45) NOT NULL, payment_amount NUMERIC(8, 2) DEFAULT NULL, payment_comment VARCHAR(45) DEFAULT NULL, payment_cause VARCHAR(45) DEFAULT NULL, INDEX IDX_6D28840DC35E566A (family_id), INDEX IDX_6D28840DB73FE63E (toylibrary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relationship (id INT AUTO_INCREMENT NOT NULL, family_id INT DEFAULT NULL, member_id INT DEFAULT NULL, is_owner TINYINT(1) NOT NULL, INDEX IDX_200444A0C35E566A (family_id), INDEX IDX_200444A07597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, tag_name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_dependance (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toy_library (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, address VARCHAR(45) DEFAULT NULL, zip_code VARCHAR(10) DEFAULT NULL, city VARCHAR(45) DEFAULT NULL, country VARCHAR(45) DEFAULT NULL, legal_status VARCHAR(45) DEFAULT NULL, max_duration_loan_day INT NOT NULL, subscription_type VARCHAR(45) NOT NULL, subscription_price_month NUMERIC(8, 2) DEFAULT NULL, token_earn_month INT DEFAULT NULL, cost_money_load NUMERIC(8, 2) DEFAULT NULL, deposit_amount NUMERIC(8, 2) DEFAULT NULL, cost_money_loan NUMERIC(8, 2) DEFAULT NULL, deposit_is_cashable TINYINT(1) NOT NULL, late_cost_by_day NUMERIC(8, 2) DEFAULT NULL, max_loan_simult_user INT NOT NULL, max_loan_simult_family INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, email VARCHAR(255) DEFAULT NULL, status VARCHAR(45) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_dependance ADD CONSTRAINT FK_9225CE63126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE category_dependance ADD CONSTRAINT FK_9225CE6312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE item_tag ADD CONSTRAINT FK_E49CCCB1126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_tag ADD CONSTRAINT FK_E49CCCB1BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78DB2D230C FOREIGN KEY (relation_ship_id) REFERENCES relationship (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78862A4B61 FOREIGN KEY (member_event_id) REFERENCES member_event (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78AC3B625A FOREIGN KEY (member_daily_session_id) REFERENCES member_daily_session (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DB73FE63E FOREIGN KEY (toylibrary_id) REFERENCES toy_library (id)');
        $this->addSql('ALTER TABLE relationship ADD CONSTRAINT FK_200444A0C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE relationship ADD CONSTRAINT FK_200444A07597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_dependance DROP FOREIGN KEY FK_9225CE6312469DE2');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03C35E566A');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DC35E566A');
        $this->addSql('ALTER TABLE relationship DROP FOREIGN KEY FK_200444A0C35E566A');
        $this->addSql('ALTER TABLE category_dependance DROP FOREIGN KEY FK_9225CE63126F525E');
        $this->addSql('ALTER TABLE item_tag DROP FOREIGN KEY FK_E49CCCB1126F525E');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03126F525E');
        $this->addSql('ALTER TABLE relationship DROP FOREIGN KEY FK_200444A07597D3FE');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78AC3B625A');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78862A4B61');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78DB2D230C');
        $this->addSql('ALTER TABLE item_tag DROP FOREIGN KEY FK_E49CCCB1BAD26311');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DB73FE63E');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_dependance');
        $this->addSql('DROP TABLE daily_session');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_select_game');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_tag');
        $this->addSql('DROP TABLE item_inventory');
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_daily_session');
        $this->addSql('DROP TABLE member_event');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE relationship');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_dependance');
        $this->addSql('DROP TABLE toy_library');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
