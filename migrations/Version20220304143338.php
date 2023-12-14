<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304143338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emplacements_materiels (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, is_delete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employes (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, paswword VARCHAR(255) NOT NULL, pole VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, is_delete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employes_pannes (id INT AUTO_INCREMENT NOT NULL, employes_id INT NOT NULL, pannes_id INT NOT NULL, date_creation DATETIME NOT NULL, is_delete TINYINT(1) NOT NULL, INDEX IDX_C561D7D8F971F91F (employes_id), INDEX IDX_C561D7D852C4C5A1 (pannes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiels (id INT AUTO_INCREMENT NOT NULL, numero_serie VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, is_delete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pannes (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, is_delete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types_materiels (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, is_delete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employes_pannes ADD CONSTRAINT FK_C561D7D8F971F91F FOREIGN KEY (employes_id) REFERENCES employes (id)');
        $this->addSql('ALTER TABLE employes_pannes ADD CONSTRAINT FK_C561D7D852C4C5A1 FOREIGN KEY (pannes_id) REFERENCES pannes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employes_pannes DROP FOREIGN KEY FK_C561D7D8F971F91F');
        $this->addSql('ALTER TABLE employes_pannes DROP FOREIGN KEY FK_C561D7D852C4C5A1');
        $this->addSql('DROP TABLE emplacements_materiels');
        $this->addSql('DROP TABLE employes');
        $this->addSql('DROP TABLE employes_pannes');
        $this->addSql('DROP TABLE materiels');
        $this->addSql('DROP TABLE pannes');
        $this->addSql('DROP TABLE types_materiels');
    }
}
