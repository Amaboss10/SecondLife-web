<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210132514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9ABA4CF8E FOREIGN KEY (expediteur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9FEA9FF92 FOREIGN KEY (destinataire) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4321D1C63B3 FOREIGN KEY (utilisateur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES personne (id_personne)');
        $this->addSql('DROP INDEX UNIQ_FCEC9EF1C6B538A ON personne');
        $this->addSql('DROP INDEX UNIQ_FCEC9EFD21908A7 ON personne');
        $this->addSql('ALTER TABLE personne ADD type VARCHAR(255) NOT NULL, ADD pseudo_user VARCHAR(20) DEFAULT NULL, ADD adresse_user VARCHAR(150) DEFAULT NULL, ADD date_naiss_user DATE DEFAULT NULL, ADD date_inscription_user DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9ABA4CF8E');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9FEA9FF92');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC1D1C63B3');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4321D1C63B3');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1D1C63B3');
        $this->addSql('ALTER TABLE personne DROP type, DROP pseudo_user, DROP adresse_user, DROP date_naiss_user, DROP date_inscription_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EF1C6B538A ON personne (mdp_personne)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EFD21908A7 ON personne (mail_personne)');
    }
}
