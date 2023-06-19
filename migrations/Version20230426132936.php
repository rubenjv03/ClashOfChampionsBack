<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426132936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS game  (id INT AUTO_INCREMENT NOT NULL, game_name VARCHAR(50) NOT NULL, game_platform VARCHAR(25) NOT NULL, game_format VARCHAR(15) NOT NULL, game_description VARCHAR(255) NOT NULL, game_img LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $table = $schema->getTable('user');

        if ($table->hasColumn('profile_img')) {
            $table->dropColumn('profile_img');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game');
        $this->addSql('ALTER TABLE user ADD profile_img LONGBLOB DEFAULT NULL');
    }
}
