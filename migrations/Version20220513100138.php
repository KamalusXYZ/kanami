<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513100138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ref VARCHAR(45) DEFAULT NULL, lang VARCHAR(45) DEFAULT NULL, publisher_game_duration VARCHAR(45) DEFAULT NULL, our_game_duration VARCHAR(45) DEFAULT NULL, player_nb_min INT DEFAULT NULL, player_nb_max INT DEFAULT NULL, age_min INT DEFAULT NULL, author VARCHAR(45) DEFAULT NULL, illustrator VARCHAR(45) DEFAULT NULL, publisher VARCHAR(45) DEFAULT NULL, item_condition VARCHAR(20) DEFAULT NULL, completeness TINYINT(1) DEFAULT NULL, available TINYINT(1) NOT NULL, archive TINYINT(1) NOT NULL, update_pseudo_user VARCHAR(45) DEFAULT NULL, update_date_time DATETIME DEFAULT NULL, archive_pseudo_user VARCHAR(45) DEFAULT NULL, archive_date_time DATETIME DEFAULT NULL, archive_cause VARCHAR(45) DEFAULT NULL, archive_game_become VARCHAR(45) DEFAULT NULL, member_item_rating_total NUMERIC(2, 1) DEFAULT NULL, member_item_rating_nb INT DEFAULT NULL, game_price NUMERIC(8, 2) DEFAULT NULL, game_origin VARCHAR(45) DEFAULT NULL, user_made_entry VARCHAR(45) DEFAULT NULL, copy_number INT DEFAULT NULL, register_date_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE item');
    }
}
