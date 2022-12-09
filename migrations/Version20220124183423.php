<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220124183423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournoi_ramasseur (tournoi_id INT NOT NULL, ramasseur_id INT NOT NULL, INDEX IDX_140D0A35F607770A (tournoi_id), INDEX IDX_140D0A35839D537D (ramasseur_id), PRIMARY KEY(tournoi_id, ramasseur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournoi_ramasseur ADD CONSTRAINT FK_140D0A35F607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournoi_ramasseur ADD CONSTRAINT FK_140D0A35839D537D FOREIGN KEY (ramasseur_id) REFERENCES ramasseur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tournoi_ramasseur');
    }
}
