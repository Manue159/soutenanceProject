<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422164454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiels ADD type_id INT NOT NULL, ADD emplacement_id INT NOT NULL');
        $this->addSql('ALTER TABLE materiels ADD CONSTRAINT FK_9C1EBE69C54C8C93 FOREIGN KEY (type_id) REFERENCES types_materiels (id)');
        $this->addSql('ALTER TABLE materiels ADD CONSTRAINT FK_9C1EBE69C4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacements_materiels (id)');
        $this->addSql('CREATE INDEX IDX_9C1EBE69C54C8C93 ON materiels (type_id)');
        $this->addSql('CREATE INDEX IDX_9C1EBE69C4598A51 ON materiels (emplacement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emplacements_materiels CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE employes CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE paswword paswword VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pole pole VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE statut statut VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE token token VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE materiels DROP FOREIGN KEY FK_9C1EBE69C54C8C93');
        $this->addSql('ALTER TABLE materiels DROP FOREIGN KEY FK_9C1EBE69C4598A51');
        $this->addSql('DROP INDEX IDX_9C1EBE69C54C8C93 ON materiels');
        $this->addSql('DROP INDEX IDX_9C1EBE69C4598A51 ON materiels');
        $this->addSql('ALTER TABLE materiels DROP type_id, DROP emplacement_id, CHANGE numero_serie numero_serie VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pannes CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE etat etat VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE types_materiels CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
