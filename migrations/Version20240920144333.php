<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240920144333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_command ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article_command ADD CONSTRAINT FK_6318AE63DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_6318AE63DCD6110 ON article_command (stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_command DROP FOREIGN KEY FK_6318AE63DCD6110');
        $this->addSql('DROP INDEX IDX_6318AE63DCD6110 ON article_command');
        $this->addSql('ALTER TABLE article_command DROP stock_id');
    }
}
