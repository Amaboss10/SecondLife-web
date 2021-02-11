<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210141740 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id_personne INT NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id_personne INT NOT NULL, pseudo_user VARCHAR(20) NOT NULL, adresse_user VARCHAR(150) NOT NULL, date_naiss_user DATE NOT NULL, date_inscription_user DATETIME NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E85F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B35F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9ABA4CF8E');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9FEA9FF92');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9ABA4CF8E FOREIGN KEY (expediteur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9FEA9FF92 FOREIGN KEY (destinataire) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC1D1C63B3');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4321D1C63B3');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4321D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1D1C63B3');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE personne DROP pseudo_user, DROP adresse_user, DROP date_naiss_user, DROP date_inscription_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9ABA4CF8E');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9FEA9FF92');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC1D1C63B3');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4321D1C63B3');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1D1C63B3');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9ABA4CF8E');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9FEA9FF92');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9ABA4CF8E FOREIGN KEY (expediteur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9FEA9FF92 FOREIGN KEY (destinataire) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC1D1C63B3');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4321D1C63B3');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4321D1C63B3 FOREIGN KEY (utilisateur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1D1C63B3');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE personne ADD pseudo_user VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD adresse_user VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD date_naiss_user DATE DEFAULT NULL, ADD date_inscription_user DATETIME DEFAULT NULL');
    }
}
