<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220124194647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournoi_equipe (tournoi_id INT NOT NULL, equipe_id INT NOT NULL, INDEX IDX_D21A14EAF607770A (tournoi_id), INDEX IDX_D21A14EA6D861B89 (equipe_id), PRIMARY KEY(tournoi_id, equipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournoi_equipe ADD CONSTRAINT FK_D21A14EAF607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournoi_equipe ADD CONSTRAINT FK_D21A14EA6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE tournoi_joueur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournoi_joueur (tournoi_id INT NOT NULL, joueur_id INT NOT NULL, INDEX IDX_B22073AA9E2D76C (joueur_id), INDEX IDX_B22073AF607770A (tournoi_id), PRIMARY KEY(tournoi_id, joueur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tournoi_joueur ADD CONSTRAINT FK_B22073AA9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournoi_joueur ADD CONSTRAINT FK_B22073AF607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE tournoi_equipe');
    }
}
