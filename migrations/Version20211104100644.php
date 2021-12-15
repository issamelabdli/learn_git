<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104100644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mediaprevoir (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_249D955CF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mediaprevoir ADD CONSTRAINT FK_249D955CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE client ADD sub_titre VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD publier_interesser TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mediaprevoir');
        $this->addSql('ALTER TABLE client DROP sub_titre');
        $this->addSql('ALTER TABLE produit DROP publier_interesser');
    }
}
