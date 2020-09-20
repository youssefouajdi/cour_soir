<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200824154328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, id_eleve INT DEFAULT NULL, id_matiere INT DEFAULT NULL, jour DATE NOT NULL, paye INT NOT NULL, reste INT NOT NULL, INDEX IDX_F4DD61D322444C7 (id_eleve), INDEX IDX_F4DD61D34E89FE3A (id_matiere), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D322444C7 FOREIGN KEY (id_eleve) REFERENCES eleve (id_eleve)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D34E89FE3A FOREIGN KEY (id_matiere) REFERENCES matiere (id_matiere)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE affectation');
    }
}
