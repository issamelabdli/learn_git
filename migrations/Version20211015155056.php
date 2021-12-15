<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211015155056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD634989D9B62 ON categorie (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455989D9B62 ON client (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B26681E989D9B62 ON evenement (slug)');
        $this->addSql('ALTER TABLE galerie ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE galerieclient ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE mediatheque ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC27989D9B62 ON produit (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52743D7B989D9B62 ON sous_categorie (slug)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_497DD634989D9B62 ON categorie');
        $this->addSql('DROP INDEX UNIQ_C7440455989D9B62 ON client');
        $this->addSql('DROP INDEX UNIQ_B26681E989D9B62 ON evenement');
        $this->addSql('ALTER TABLE galerie DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE galerieclient DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE mediatheque DROP created_at, DROP updated_at');
        $this->addSql('DROP INDEX UNIQ_29A5EC27989D9B62 ON produit');
        $this->addSql('DROP INDEX UNIQ_52743D7B989D9B62 ON sous_categorie');
    }
}
