<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014165216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, switcher VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, publier TINYINT(1) DEFAULT NULL, seo_titre VARCHAR(255) DEFAULT NULL, seo_description LONGTEXT DEFAULT NULL, seo_keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_C7440455FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, switcher VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, publier TINYINT(1) DEFAULT NULL, seo_titre VARCHAR(255) DEFAULT NULL, seo_description LONGTEXT DEFAULT NULL, seo_keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerie (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_9E7D1590F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerieclient (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_1CFAE75F19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mediatheque (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, publier TINYINT(1) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, INDEX IDX_2B49E7E7FD02F13 (evenement_id), INDEX IDX_2B49E7E7365BF48 (sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specification (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, valeur VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_E3F1A9AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE galerie ADD CONSTRAINT FK_9E7D1590F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE galerieclient ADD CONSTRAINT FK_1CFAE75F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE mediatheque ADD CONSTRAINT FK_2B49E7E7FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE mediatheque ADD CONSTRAINT FK_2B49E7E7365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE specification ADD CONSTRAINT FK_E3F1A9AF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galerieclient DROP FOREIGN KEY FK_1CFAE75F19EB6921');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455FD02F13');
        $this->addSql('ALTER TABLE mediatheque DROP FOREIGN KEY FK_2B49E7E7FD02F13');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE galerieclient');
        $this->addSql('DROP TABLE mediatheque');
        $this->addSql('DROP TABLE specification');
    }
}
