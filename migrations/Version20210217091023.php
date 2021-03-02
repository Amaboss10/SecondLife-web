<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217091023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id_personne INT NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, categorie INT NOT NULL, marque INT NOT NULL, sous_categorie INT NOT NULL, utilisateur INT NOT NULL, titre_annonce VARCHAR(50) NOT NULL, description_annonce LONGTEXT NOT NULL, prix_annonce INT NOT NULL, poids_annonce INT NOT NULL, etat_annonce VARCHAR(50) NOT NULL, date_publi_annonce DATETIME NOT NULL, est_valide TINYINT(1) NOT NULL, INDEX IDX_F65593E5497DD634 (categorie), INDEX IDX_F65593E55A6F91CE (marque), INDEX IDX_F65593E552743D7B (sous_categorie), INDEX IDX_F65593E51D1C63B3 (utilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_faq (id INT AUTO_INCREMENT NOT NULL, administrateur INT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, INDEX IDX_C648B4CD32EB52E8 (administrateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, expediteur INT DEFAULT NULL, destinataire INT DEFAULT NULL, INDEX IDX_8A8E26E9ABA4CF8E (expediteur), INDEX IDX_8A8E26E9FEA9FF92 (destinataire), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, categorie_faq INT NOT NULL, administrateur INT NOT NULL, titre_probleme VARCHAR(255) NOT NULL, description_probleme LONGTEXT NOT NULL, date_probleme DATETIME NOT NULL, INDEX IDX_E8FF75CCC648B4CD (categorie_faq), INDEX IDX_E8FF75CC32EB52E8 (administrateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, annonce INT NOT NULL, utilisateur INT NOT NULL, date_favoris DATETIME NOT NULL, INDEX IDX_8933C432F65593E5 (annonce), INDEX IDX_8933C4321D1C63B3 (utilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, nom_marque VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, utilisateur INT DEFAULT NULL, conversation INT DEFAULT NULL, texte_message LONGTEXT NOT NULL, date_message DATETIME NOT NULL, etat_envoi INT NOT NULL, INDEX IDX_B6BD307F1D1C63B3 (utilisateur), INDEX IDX_B6BD307F8A8E26E9 (conversation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id_personne INT AUTO_INCREMENT NOT NULL, nom_personne VARCHAR(50) NOT NULL, prenom_personne VARCHAR(30) NOT NULL, mail_personne VARCHAR(100) NOT NULL, mdp_personne VARCHAR(255) NOT NULL, lien_image_personne VARCHAR(250) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_annonce (id INT AUTO_INCREMENT NOT NULL, annonce INT NOT NULL, lien_photo_annonce VARCHAR(255) NOT NULL, INDEX IDX_C3B58468F65593E5 (annonce), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categorie (id INT AUTO_INCREMENT NOT NULL, categorie INT NOT NULL, nom_sous_categorie VARCHAR(70) NOT NULL, INDEX IDX_52743D7B497DD634 (categorie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id_personne INT NOT NULL, pseudo_user VARCHAR(20) NOT NULL, adresse_user VARCHAR(150) NOT NULL, date_naiss_user DATE NOT NULL, date_inscription_user DATETIME NOT NULL, PRIMARY KEY(id_personne)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E85F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5497DD634 FOREIGN KEY (categorie) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E55A6F91CE FOREIGN KEY (marque) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E552743D7B FOREIGN KEY (sous_categorie) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E51D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE categorie_faq ADD CONSTRAINT FK_C648B4CD32EB52E8 FOREIGN KEY (administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9ABA4CF8E FOREIGN KEY (expediteur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9FEA9FF92 FOREIGN KEY (destinataire) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CCC648B4CD FOREIGN KEY (categorie_faq) REFERENCES categorie_faq (id)');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC32EB52E8 FOREIGN KEY (administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432F65593E5 FOREIGN KEY (annonce) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4321D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8A8E26E9 FOREIGN KEY (conversation) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE photo_annonce ADD CONSTRAINT FK_C3B58468F65593E5 FOREIGN KEY (annonce) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7B497DD634 FOREIGN KEY (categorie) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B35F15257A FOREIGN KEY (id_personne) REFERENCES personne (id_personne) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_faq DROP FOREIGN KEY FK_C648B4CD32EB52E8');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC32EB52E8');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432F65593E5');
        $this->addSql('ALTER TABLE photo_annonce DROP FOREIGN KEY FK_C3B58468F65593E5');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5497DD634');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7B497DD634');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CCC648B4CD');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8A8E26E9');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E55A6F91CE');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E85F15257A');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B35F15257A');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E552743D7B');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E51D1C63B3');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9ABA4CF8E');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9FEA9FF92');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4321D1C63B3');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1D1C63B3');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_faq');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE photo_annonce');
        $this->addSql('DROP TABLE sous_categorie');
        $this->addSql('DROP TABLE utilisateur');
    }
    
}
