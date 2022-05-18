<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210813174607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations DROP nom_formateur, DROP prenom_formateur, CHANGE id_formateur id_formateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_40902137369CFA23 FOREIGN KEY (id_formateur_id) REFERENCES formateurs (id)');
        $this->addSql('CREATE INDEX IDX_40902137369CFA23 ON formations (id_formateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations DROP FOREIGN KEY FK_40902137369CFA23');
        $this->addSql('DROP INDEX IDX_40902137369CFA23 ON formations');
        $this->addSql('ALTER TABLE formations ADD nom_formateur VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom_formateur VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id_formateur_id id_formateur INT NOT NULL');
    }
}
