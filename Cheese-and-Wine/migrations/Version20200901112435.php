<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901112435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cheese (id INT AUTO_INCREMENT NOT NULL, origin_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, milk VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_EDCE51C356A273CC (origin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cheese_wine (cheese_id INT NOT NULL, wine_id INT NOT NULL, INDEX IDX_A6CCD8542AD46E66 (cheese_id), INDEX IDX_A6CCD85428A2BD76 (wine_id), PRIMARY KEY(cheese_id, wine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE origin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(180) NOT NULL, name VARCHAR(45) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, api_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_proposal (id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(255) NOT NULL, main_product VARCHAR(255) NOT NULL, associated_product VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine (id INT AUTO_INCREMENT NOT NULL, origin_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, appellation VARCHAR(45) NOT NULL, picture VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_560C646856A273CC (origin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cheese ADD CONSTRAINT FK_EDCE51C356A273CC FOREIGN KEY (origin_id) REFERENCES origin (id)');
        $this->addSql('ALTER TABLE cheese_wine ADD CONSTRAINT FK_A6CCD8542AD46E66 FOREIGN KEY (cheese_id) REFERENCES cheese (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cheese_wine ADD CONSTRAINT FK_A6CCD85428A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C646856A273CC FOREIGN KEY (origin_id) REFERENCES origin (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cheese_wine DROP FOREIGN KEY FK_A6CCD8542AD46E66');
        $this->addSql('ALTER TABLE cheese DROP FOREIGN KEY FK_EDCE51C356A273CC');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C646856A273CC');
        $this->addSql('ALTER TABLE cheese_wine DROP FOREIGN KEY FK_A6CCD85428A2BD76');
        $this->addSql('DROP TABLE cheese');
        $this->addSql('DROP TABLE cheese_wine');
        $this->addSql('DROP TABLE origin');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_proposal');
        $this->addSql('DROP TABLE wine');
    }
}
