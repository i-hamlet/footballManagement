<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618152638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, INDEX IDX_98197A65296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, balance NUMERIC(14, 2) NOT NULL, UNIQUE INDEX name_country_idx (name, country), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transfer (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, buyer_id INT NOT NULL, player_id INT NOT NULL, price NUMERIC(14, 2) NOT NULL, INDEX IDX_4034A3C08DE820D9 (seller_id), INDEX IDX_4034A3C06C755722 (buyer_id), INDEX IDX_4034A3C099E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C08DE820D9 FOREIGN KEY (seller_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C06C755722 FOREIGN KEY (buyer_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C099E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65296CD8AE');
        $this->addSql('ALTER TABLE transfer DROP FOREIGN KEY FK_4034A3C08DE820D9');
        $this->addSql('ALTER TABLE transfer DROP FOREIGN KEY FK_4034A3C06C755722');
        $this->addSql('ALTER TABLE transfer DROP FOREIGN KEY FK_4034A3C099E6F5DF');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE transfer');
    }
}
