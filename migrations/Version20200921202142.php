<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921202142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve ADD id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F779F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ECA105F779F37AE5 ON eleve (id_user_id)');
        $this->addSql('ALTER TABLE personne ADD id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EF79F37AE5 ON personne (id_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F779F37AE5');
        $this->addSql('DROP INDEX UNIQ_ECA105F779F37AE5 ON eleve');
        $this->addSql('ALTER TABLE eleve DROP id_user_id');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF79F37AE5');
        $this->addSql('DROP INDEX UNIQ_FCEC9EF79F37AE5 ON personne');
        $this->addSql('ALTER TABLE personne DROP id_user_id');
    }
}
