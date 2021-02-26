<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215112704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD lieu VARCHAR(255) NOT NULL, ADD mode_livraison LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC1D1C63B3');
        $this->addSql('DROP INDEX IDX_E8FF75CC1D1C63B3 ON faq');
        $this->addSql('ALTER TABLE faq ADD solution_probleme LONGTEXT NOT NULL, ADD lien_tutoriel LONGTEXT DEFAULT NULL, DROP utilisateur, DROP est_resolue, CHANGE description_probleme description_probleme LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP lieu, DROP mode_livraison');
        $this->addSql('ALTER TABLE faq ADD utilisateur INT DEFAULT NULL, ADD est_resolue TINYINT(1) NOT NULL, DROP solution_probleme, DROP lien_tutoriel, CHANGE description_probleme description_probleme LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_E8FF75CC1D1C63B3 ON faq (utilisateur)');
    }
}
