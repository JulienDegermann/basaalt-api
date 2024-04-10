<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240410131710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, band_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, released_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_39986E4349ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_links (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, plateform_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_A73AEB3E1137ABCF (album_id), INDEX IDX_A73AEB3ECCAA542F (plateform_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_23A0E6612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, insee_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, text VARCHAR(255) NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE live (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, event_name VARCHAR(255) DEFAULT NULL, event_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', address VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_530F2CAF8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B6BD307FF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, size VARCHAR(255) NOT NULL, INDEX IDX_F52993986C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_article (order_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F440A72D8D9F6D38 (order_id), INDEX IDX_F440A72D7294869C (article_id), PRIMARY KEY(order_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plateform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, released_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_33EDEEA11137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song_links (id INT AUTO_INCREMENT NOT NULL, plateform_id INT NOT NULL, song_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_1C26345DCCAA542F (plateform_id), INDEX IDX_1C26345DA0BDB2F3 (song_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, size VARCHAR(255) NOT NULL, INDEX IDX_4B3656607294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, band_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, user_name VARCHAR(255) DEFAULT NULL, birth_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', band_role VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8D93D64949ABEB17 (band_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4349ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE album_links ADD CONSTRAINT FK_A73AEB3E1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE album_links ADD CONSTRAINT FK_A73AEB3ECCAA542F FOREIGN KEY (plateform_id) REFERENCES plateform (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE live ADD CONSTRAINT FK_530F2CAF8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA11137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE song_links ADD CONSTRAINT FK_1C26345DCCAA542F FOREIGN KEY (plateform_id) REFERENCES plateform (id)');
        $this->addSql('ALTER TABLE song_links ADD CONSTRAINT FK_1C26345DA0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656607294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64949ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4349ABEB17');
        $this->addSql('ALTER TABLE album_links DROP FOREIGN KEY FK_A73AEB3E1137ABCF');
        $this->addSql('ALTER TABLE album_links DROP FOREIGN KEY FK_A73AEB3ECCAA542F');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE live DROP FOREIGN KEY FK_530F2CAF8BAC62AF');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF675F31B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986C755722');
        $this->addSql('ALTER TABLE order_article DROP FOREIGN KEY FK_F440A72D8D9F6D38');
        $this->addSql('ALTER TABLE order_article DROP FOREIGN KEY FK_F440A72D7294869C');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA11137ABCF');
        $this->addSql('ALTER TABLE song_links DROP FOREIGN KEY FK_1C26345DCCAA542F');
        $this->addSql('ALTER TABLE song_links DROP FOREIGN KEY FK_1C26345DA0BDB2F3');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656607294869C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64949ABEB17');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_links');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE live');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_article');
        $this->addSql('DROP TABLE plateform');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE song_links');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
    }
}
