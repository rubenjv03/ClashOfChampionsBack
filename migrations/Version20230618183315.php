<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618183315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament CHANGE date_begin date_begin VARCHAR(30) NOT NULL, CHANGE date_end date_end VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE birthdate birthdate VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX game_name ON game (game_name)');
        $this->addSql('ALTER TABLE match_game ADD CONSTRAINT match_game_ibfk_1 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX tournament_id ON match_game (tournament_id)');
        $this->addSql('ALTER TABLE tournament CHANGE date_begin date_begin DATETIME NOT NULL, CHANGE date_end date_end DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT tournament_ibfk_1 FOREIGN KEY (game_name) REFERENCES game (game_name) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX game_name ON tournament (game_name)');
        $this->addSql('ALTER TABLE user CHANGE birthdate birthdate DATE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX nickname ON user (nickname)');
        $this->addSql('CREATE UNIQUE INDEX mail ON user (mail)');
    }
}
