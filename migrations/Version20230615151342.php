<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615151342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE footer (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(11) NOT NULL, is_day_closed TINYINT(1) NOT NULL, is_lunch_closed TINYINT(1) NOT NULL, lunch_start TIME DEFAULT NULL, lunchend TIME DEFAULT NULL, lunch_max_places INT DEFAULT NULL, is_evening_closed TINYINT(1) NOT NULL, evening_start TIME DEFAULT NULL, evening_end TIME DEFAULT NULL, evening_max_places INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE footer');
    }
}
