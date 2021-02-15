<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215132802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_faq DROP FOREIGN KEY FK_C648B4CDF8DEFEE');
        $this->addSql('DROP INDEX IDX_C648B4CDF8DEFEE ON categorie_faq');
        $this->addSql('ALTER TABLE categorie_faq CHANGE id_administrateur administrateur INT NOT NULL');
        $this->addSql('ALTER TABLE categorie_faq ADD CONSTRAINT FK_C648B4CD32EB52E8 FOREIGN KEY (administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_C648B4CD32EB52E8 ON categorie_faq (administrateur)');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CCF8DEFEE');
        $this->addSql('DROP INDEX IDX_E8FF75CCF8DEFEE ON faq');
        $this->addSql('ALTER TABLE faq DROP est_resolue, CHANGE id_administrateur administrateur INT NOT NULL');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC32EB52E8 FOREIGN KEY (administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_E8FF75CC32EB52E8 ON faq (administrateur)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F50EAE44');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA94F539B');
        $this->addSql('DROP INDEX IDX_B6BD307FA94F539B ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F50EAE44 ON message');
        $this->addSql('ALTER TABLE message ADD utilisateur INT DEFAULT NULL, ADD conversation INT DEFAULT NULL, DROP id_utilisateur, DROP id_conversation');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1D1C63B3 FOREIGN KEY (utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8A8E26E9 FOREIGN KEY (conversation) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F1D1C63B3 ON message (utilisateur)');
        $this->addSql('CREATE INDEX IDX_B6BD307F8A8E26E9 ON message (conversation)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_faq DROP FOREIGN KEY FK_C648B4CD32EB52E8');
        $this->addSql('DROP INDEX IDX_C648B4CD32EB52E8 ON categorie_faq');
        $this->addSql('ALTER TABLE categorie_faq CHANGE administrateur id_administrateur INT NOT NULL');
        $this->addSql('ALTER TABLE categorie_faq ADD CONSTRAINT FK_C648B4CDF8DEFEE FOREIGN KEY (id_administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_C648B4CDF8DEFEE ON categorie_faq (id_administrateur)');
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC32EB52E8');
        $this->addSql('DROP INDEX IDX_E8FF75CC32EB52E8 ON faq');
        $this->addSql('ALTER TABLE faq ADD est_resolue TINYINT(1) NOT NULL, CHANGE administrateur id_administrateur INT NOT NULL');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CCF8DEFEE FOREIGN KEY (id_administrateur) REFERENCES administrateur (id_personne)');
        $this->addSql('CREATE INDEX IDX_E8FF75CCF8DEFEE ON faq (id_administrateur)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1D1C63B3');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8A8E26E9');
        $this->addSql('DROP INDEX IDX_B6BD307F1D1C63B3 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F8A8E26E9 ON message');
        $this->addSql('ALTER TABLE message ADD id_utilisateur INT DEFAULT NULL, ADD id_conversation INT DEFAULT NULL, DROP utilisateur, DROP conversation');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_personne)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA94F539B FOREIGN KEY (id_conversation) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA94F539B ON message (id_conversation)');
        $this->addSql('CREATE INDEX IDX_B6BD307F50EAE44 ON message (id_utilisateur)');
    }
}
