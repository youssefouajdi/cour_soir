<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200823172002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, id_seance INT DEFAULT NULL, id_eleve INT DEFAULT NULL, INDEX test11 (id_seance), INDEX test12 (id_eleve), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id_eleve INT AUTO_INCREMENT NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, transport TINYINT(1) NOT NULL, dt_inscription DATE NOT NULL, email VARCHAR(250) NOT NULL, tel VARCHAR(250) NOT NULL, type VARCHAR(30) NOT NULL, niveau VARCHAR(30) NOT NULL, PRIMARY KEY(id_eleve)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id_matiere INT AUTO_INCREMENT NOT NULL, nom_matiere VARCHAR(250) NOT NULL, niveau INT NOT NULL, prix INT NOT NULL, PRIMARY KEY(id_matiere)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id_paiement INT AUTO_INCREMENT NOT NULL, id_eleve INT DEFAULT NULL, dt_paiement DATE NOT NULL, mode VARCHAR(250) NOT NULL, montant_total INT NOT NULL, motant_rest INT NOT NULL, INDEX test03 (id_eleve), PRIMARY KEY(id_paiement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement_matiere (id INT AUTO_INCREMENT NOT NULL, id_paiement INT DEFAULT NULL, id_matiere INT DEFAULT NULL, INDEX test25 (id_matiere), INDEX test22 (id_paiement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, fonctionnalite VARCHAR(255) NOT NULL, salaire VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel (id_personnel INT AUTO_INCREMENT NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, fonctionnalite VARCHAR(250) NOT NULL, salaire INT NOT NULL, PRIMARY KEY(id_personnel)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, id_matiere INT DEFAULT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, tel VARCHAR(250) NOT NULL, INDEX test67 (id_matiere), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id_seance INT AUTO_INCREMENT NOT NULL, id_matiere INT DEFAULT NULL, id_professeur INT DEFAULT NULL, dtdebut DATE NOT NULL, dtfin DATE NOT NULL, h_debut TIME NOT NULL, h_fin TIME NOT NULL, salle INT NOT NULL, effectuer TINYINT(1) NOT NULL, jour LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX test (id_matiere), INDEX test123 (id_professeur), PRIMARY KEY(id_seance)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE virement (id_virement INT AUTO_INCREMENT NOT NULL, id_prof INT DEFAULT NULL, id_personnel INT DEFAULT NULL, dt_virement DATE NOT NULL, total_salaire INT NOT NULL, reste INT NOT NULL, INDEX test45 (id_prof), INDEX test56 (id_personnel), PRIMARY KEY(id_virement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9F94A48E3 FOREIGN KEY (id_seance) REFERENCES seance (id_seance)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C922444C7 FOREIGN KEY (id_eleve) REFERENCES eleve (id_eleve)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E22444C7 FOREIGN KEY (id_eleve) REFERENCES eleve (id_eleve)');
        $this->addSql('ALTER TABLE paiement_matiere ADD CONSTRAINT FK_8D2EE7BBE107968B FOREIGN KEY (id_paiement) REFERENCES paiement (id_paiement)');
        $this->addSql('ALTER TABLE paiement_matiere ADD CONSTRAINT FK_8D2EE7BB4E89FE3A FOREIGN KEY (id_matiere) REFERENCES matiere (id_matiere)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A552994E89FE3A FOREIGN KEY (id_matiere) REFERENCES matiere (id_matiere)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E4E89FE3A FOREIGN KEY (id_matiere) REFERENCES matiere (id_matiere)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EB22FD24E FOREIGN KEY (id_professeur) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE virement ADD CONSTRAINT FK_2D4DCFA6D09A6CB9 FOREIGN KEY (id_prof) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE virement ADD CONSTRAINT FK_2D4DCFA626894FF9 FOREIGN KEY (id_personnel) REFERENCES personnel (id_personnel)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C922444C7');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E22444C7');
        $this->addSql('ALTER TABLE paiement_matiere DROP FOREIGN KEY FK_8D2EE7BB4E89FE3A');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A552994E89FE3A');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E4E89FE3A');
        $this->addSql('ALTER TABLE paiement_matiere DROP FOREIGN KEY FK_8D2EE7BBE107968B');
        $this->addSql('ALTER TABLE virement DROP FOREIGN KEY FK_2D4DCFA626894FF9');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EB22FD24E');
        $this->addSql('ALTER TABLE virement DROP FOREIGN KEY FK_2D4DCFA6D09A6CB9');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9F94A48E3');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE paiement_matiere');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE virement');
    }
}
