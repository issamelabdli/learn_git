<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018092215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_evenement (client_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_E006B81119EB6921 (client_id), INDEX IDX_E006B811FD02F13 (evenement_id), PRIMARY KEY(client_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_evenement ADD CONSTRAINT FK_E006B81119EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_evenement ADD CONSTRAINT FK_E006B811FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455FD02F13');
        $this->addSql('DROP INDEX IDX_C7440455FD02F13 ON client');
        $this->addSql('ALTER TABLE client DROP evenement_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client_evenement');
        $this->addSql('ALTER TABLE client ADD evenement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_C7440455FD02F13 ON client (evenement_id)');
    }
}
