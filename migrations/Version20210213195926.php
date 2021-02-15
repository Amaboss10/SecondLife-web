<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213195926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E51D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_F65593E51D1C63B3 ON annonce (utilisateur)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E51D1C63B3');
        $this->addSql('DROP INDEX IDX_F65593E51D1C63B3 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP utilisateur');
    }
}
