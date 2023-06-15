<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615115307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, is_publish TINYINT(1) NOT NULL, INDEX IDX_957D8CB87E9E4C8C (photo_id), INDEX IDX_957D8CB812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, is_publish TINYINT(1) NOT NULL, INDEX IDX_7D053A937E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB87E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A937E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB87E9E4C8C');
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB812469DE2');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A937E9E4C8C');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE menu');
    }
}
