<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523085121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member ADD relation_ship_id INT DEFAULT NULL, ADD member_event_id INT DEFAULT NULL, ADD member_daily_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78DB2D230C FOREIGN KEY (relation_ship_id) REFERENCES relationship (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78862A4B61 FOREIGN KEY (member_event_id) REFERENCES member_event (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78AC3B625A FOREIGN KEY (member_daily_session_id) REFERENCES member_daily_session (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78DB2D230C ON member (relation_ship_id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78862A4B61 ON member (member_event_id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78AC3B625A ON member (member_daily_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78DB2D230C');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78862A4B61');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78AC3B625A');
        $this->addSql('DROP INDEX IDX_70E4FA78DB2D230C ON member');
        $this->addSql('DROP INDEX IDX_70E4FA78862A4B61 ON member');
        $this->addSql('DROP INDEX IDX_70E4FA78AC3B625A ON member');
        $this->addSql('ALTER TABLE member DROP relation_ship_id, DROP member_event_id, DROP member_daily_session_id');
    }
}
