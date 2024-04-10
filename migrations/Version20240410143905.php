<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240410143905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_order (id INT AUTO_INCREMENT NOT NULL, buyer_id INT DEFAULT NULL, city_id INT NOT NULL, credit_card VARCHAR(255) NOT NULL, total_price DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_17EB68C06C755722 (buyer_id), INDEX IDX_17EB68C08BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C06C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C08BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE order_article DROP FOREIGN KEY FK_F440A72D7294869C');
        $this->addSql('ALTER TABLE order_article DROP FOREIGN KEY FK_F440A72D8D9F6D38');
        $this->addSql('DROP TABLE order_article');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986C755722');
        $this->addSql('DROP INDEX IDX_F52993986C755722 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD user_order_id INT DEFAULT NULL, DROP buyer_id, DROP status, DROP price, DROP size');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986D128938 FOREIGN KEY (user_order_id) REFERENCES user_order (id)');
        $this->addSql('CREATE INDEX IDX_F52993986D128938 ON `order` (user_order_id)');
        $this->addSql('ALTER TABLE stock ADD orders_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_4B365660CFFE9AD6 ON stock (orders_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986D128938');
        $this->addSql('CREATE TABLE order_article (order_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F440A72D8D9F6D38 (order_id), INDEX IDX_F440A72D7294869C (article_id), PRIMARY KEY(order_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C06C755722');
        $this->addSql('ALTER TABLE user_order DROP FOREIGN KEY FK_17EB68C08BAC62AF');
        $this->addSql('DROP TABLE user_order');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660CFFE9AD6');
        $this->addSql('DROP INDEX IDX_4B365660CFFE9AD6 ON stock');
        $this->addSql('ALTER TABLE stock DROP orders_id');
        $this->addSql('DROP INDEX IDX_F52993986D128938 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD buyer_id INT NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD size VARCHAR(255) NOT NULL, DROP user_order_id');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986C755722 FOREIGN KEY (buyer_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F52993986C755722 ON `order` (buyer_id)');
    }
}
