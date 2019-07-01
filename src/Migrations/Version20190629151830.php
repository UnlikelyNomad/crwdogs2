<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190629151830 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE forum_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, redirect_url VARCHAR(255) DEFAULT NULL, role_mod VARCHAR(255) NOT NULL, num_topics INT NOT NULL, num_posts INT NOT NULL, last_post DATETIME DEFAULT NULL, last_post_id INT DEFAULT NULL, last_poster_id INT DEFAULT NULL, sort INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message LONGTEXT NOT NULL, ip VARCHAR(50) NOT NULL, posted DATETIME NOT NULL, edited DATETIME DEFAULT NULL, edit_user_id INT DEFAULT NULL, topic_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_topic (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, category_id INT NOT NULL, user_id INT NOT NULL, message LONGTEXT NOT NULL, last_post DATETIME DEFAULT NULL, last_post_id INT DEFAULT NULL, created DATETIME NOT NULL, num_replies INT NOT NULL, closed TINYINT(1) NOT NULL, sticky TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD signature LONGTEXT DEFAULT NULL, ADD num_disp_topics INT NOT NULL, ADD num_disp_posts INT NOT NULL, ADD num_posts INT NOT NULL, ADD last_post DATETIME DEFAULT NULL, ADD registered DATETIME NOT NULL, ADD reg_ip VARCHAR(40) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD login_ip VARCHAR(50) DEFAULT NULL, ADD temp_key VARCHAR(128) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE forum_category');
        $this->addSql('DROP TABLE forum_post');
        $this->addSql('DROP TABLE forum_topic');
        $this->addSql('ALTER TABLE user DROP signature, DROP num_disp_topics, DROP num_disp_posts, DROP num_posts, DROP last_post, DROP registered, DROP reg_ip, DROP last_login, DROP login_ip, DROP temp_key');
    }
}
