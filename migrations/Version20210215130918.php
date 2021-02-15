<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215130918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_faq (id INT AUTO_INCREMENT NOT NULL, id_administrateur INT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, INDEX IDX_C648B4CDF8DEFEE (id_administrateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_faq ADD CONSTRAINT FK_C648B4CDF8DEFEE FOREIGN KEY (id_administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('DROP TABLE reponse_faq');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5365BF48');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E54827B9B2');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('DROP INDEX IDX_F65593E5BCF5E72D ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E54827B9B2 ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E5365BF48 ON annonce');
        $this->addSql('ALTER TABLE annonce ADD categorie INT NOT NULL, ADD marque INT NOT NULL, ADD sous_categorie INT NOT NULL, DROP marque_id, DROP categorie_id, DROP sous_categorie_id, CHANGE utilisateur utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5497DD634 FOREIGN KEY (categorie) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E55A6F91CE FOREIGN KEY (marque) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E552743D7B FOREIGN KEY (sous_categorie) REFERENCES sous_categorie (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5497DD634 ON annonce (categorie)');
        $this->addSql('CREATE INDEX IDX_F65593E55A6F91CE ON annonce (marque)');
        $this->addSql('CREATE INDEX IDX_F65593E552743D7B ON annonce (sous_categorie)');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC1D1C63B3');
        $this->addSql('DROP INDEX IDX_E8FF75CC1D1C63B3 ON faq');
        $this->addSql('ALTER TABLE faq ADD categorie_faq INT NOT NULL, ADD id_administrateur INT NOT NULL, DROP utilisateur');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CCC648B4CD FOREIGN KEY (categorie_faq) REFERENCES categorie_faq (id)');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CCF8DEFEE FOREIGN KEY (id_administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_E8FF75CCC648B4CD ON faq (categorie_faq)');
        $this->addSql('CREATE INDEX IDX_E8FF75CCF8DEFEE ON faq (id_administrateur)');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4322D8F2BF8');
        $this->addSql('DROP INDEX IDX_8933C4322D8F2BF8 ON favoris');
        $this->addSql('ALTER TABLE favoris CHANGE utilisateur utilisateur INT NOT NULL, CHANGE id_annonce_id annonce INT NOT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432F65593E5 FOREIGN KEY (annonce) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_8933C432F65593E5 ON favoris (annonce)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1D1C63B3');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE0F2C01E');
        $this->addSql('DROP INDEX IDX_B6BD307F1D1C63B3 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FE0F2C01E ON message');
        $this->addSql('ALTER TABLE message ADD id_conversation INT DEFAULT NULL, DROP id_conversation_id, CHANGE utilisateur id_utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA94F539B FOREIGN KEY (id_conversation) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F50EAE44 ON message (id_utilisateur)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA94F539B ON message (id_conversation)');
        $this->addSql('ALTER TABLE photo_annonce DROP FOREIGN KEY FK_C3B584688805AB2F');
        $this->addSql('DROP INDEX IDX_C3B584688805AB2F ON photo_annonce');
        $this->addSql('ALTER TABLE photo_annonce CHANGE annonce_id annonce INT NOT NULL');
        $this->addSql('ALTER TABLE photo_annonce ADD CONSTRAINT FK_C3B58468F65593E5 FOREIGN KEY (annonce) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_C3B58468F65593E5 ON photo_annonce (annonce)');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BBCF5E72D');
        $this->addSql('DROP INDEX IDX_52743D7BBCF5E72D ON sous_categorie');
        $this->addSql('ALTER TABLE sous_categorie CHANGE categorie_id categorie INT NOT NULL');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7B497DD634 FOREIGN KEY (categorie) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_52743D7B497DD634 ON sous_categorie (categorie)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CCC648B4CD');
        $this->addSql('CREATE TABLE reponse_faq (id INT AUTO_INCREMENT NOT NULL, id_faq_id INT NOT NULL, utilisateur INT DEFAULT NULL, texte_reponse LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_reponse DATETIME NOT NULL, INDEX IDX_8052E7E8A7897D2F (id_faq_id), UNIQUE INDEX UNIQ_8052E7E81D1C63B3 (utilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reponse_faq ADD CONSTRAINT FK_8052E7E81D1C63B3 FOREIGN KEY (utilisateur) REFERENCES personne (id_personne)');
        $this->addSql('ALTER TABLE reponse_faq ADD CONSTRAINT FK_8052E7E8A7897D2F FOREIGN KEY (id_faq_id) REFERENCES faq (id)');
        $this->addSql('DROP TABLE categorie_faq');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5497DD634');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E55A6F91CE');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E552743D7B');
        $this->addSql('DROP INDEX IDX_F65593E5497DD634 ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E55A6F91CE ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E552743D7B ON annonce');
        $this->addSql('ALTER TABLE annonce ADD marque_id INT DEFAULT NULL, ADD categorie_id INT NOT NULL, ADD sous_categorie_id INT NOT NULL, DROP categorie, DROP marque, DROP sous_categorie, CHANGE utilisateur utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E54827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5BCF5E72D ON annonce (categorie_id)');
        $this->addSql('CREATE INDEX IDX_F65593E54827B9B2 ON annonce (marque_id)');
        $this->addSql('CREATE INDEX IDX_F65593E5365BF48 ON annonce (sous_categorie_id)');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CCF8DEFEE');
        $this->addSql('DROP INDEX IDX_E8FF75CCC648B4CD ON faq');
        $this->addSql('DROP INDEX IDX_E8FF75CCF8DEFEE ON faq');
        $this->addSql('ALTER TABLE faq ADD utilisateur INT DEFAULT NULL, DROP categorie_faq, DROP id_administrateur');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_E8FF75CC1D1C63B3 ON faq (utilisateur)');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432F65593E5');
        $this->addSql('DROP INDEX IDX_8933C432F65593E5 ON favoris');
        $this->addSql('ALTER TABLE favoris CHANGE utilisateur utilisateur INT DEFAULT NULL, CHANGE annonce id_annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4322D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_8933C4322D8F2BF8 ON favoris (id_annonce_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F50EAE44');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA94F539B');
        $this->addSql('DROP INDEX IDX_B6BD307F50EAE44 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FA94F539B ON message');
        $this->addSql('ALTER TABLE message ADD id_conversation_id INT NOT NULL, ADD utilisateur INT DEFAULT NULL, DROP id_utilisateur, DROP id_conversation');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE0F2C01E FOREIGN KEY (id_conversation_id) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F1D1C63B3 ON message (utilisateur)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE0F2C01E ON message (id_conversation_id)');
        $this->addSql('ALTER TABLE photo_annonce DROP FOREIGN KEY FK_C3B58468F65593E5');
        $this->addSql('DROP INDEX IDX_C3B58468F65593E5 ON photo_annonce');
        $this->addSql('ALTER TABLE photo_annonce CHANGE annonce annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo_annonce ADD CONSTRAINT FK_C3B584688805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_C3B584688805AB2F ON photo_annonce (annonce_id)');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7B497DD634');
        $this->addSql('DROP INDEX IDX_52743D7B497DD634 ON sous_categorie');
        $this->addSql('ALTER TABLE sous_categorie CHANGE categorie categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_52743D7BBCF5E72D ON sous_categorie (categorie_id)');
    }
}
