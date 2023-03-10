<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227143624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX team_name ON team');
        $this->addSql('DROP INDEX nickname ON user');
        $this->addSql('DROP INDEX mail ON user');
        $this->addSql('ALTER TABLE user CHANGE birthdate birthdate VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX team_name ON team (team_name)');
        $this->addSql('ALTER TABLE user CHANGE birthdate birthdate DATE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX nickname ON user (nickname)');
        $this->addSql('CREATE UNIQUE INDEX mail ON user (mail)');
    }
}
