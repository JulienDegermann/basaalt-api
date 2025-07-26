<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725194721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band_member (id INT AUTO_INCREMENT NOT NULL, band_id INT DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, band_role VARCHAR(255) DEFAULT NULL, birth_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_89A1C7A949ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band_member ADD CONSTRAINT FK_89A1C7A949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64949ABEB17');
        $this->addSql('DROP INDEX IDX_8D93D64949ABEB17 ON user');
        $this->addSql('ALTER TABLE user DROP band_id, DROP band_role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band_member DROP FOREIGN KEY FK_89A1C7A949ABEB17');
        $this->addSql('DROP TABLE band_member');
        $this->addSql('ALTER TABLE user ADD band_id INT DEFAULT NULL, ADD band_role VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D64949ABEB17 ON user (band_id)');
    }
}
