<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190630040524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE forum_category DROP last_post, DROP last_post_id, DROP last_poster_id');
        $this->addSql('ALTER TABLE forum_post DROP edit_user_id');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5A1F55203D FOREIGN KEY (topic_id) REFERENCES forum_topic (id)');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_996BCC5A1F55203D ON forum_post (topic_id)');
        $this->addSql('CREATE INDEX IDX_996BCC5AA76ED395 ON forum_post (user_id)');
        $this->addSql('ALTER TABLE forum_topic DROP last_post_id');
        $this->addSql('ALTER TABLE forum_topic ADD CONSTRAINT FK_853478CC12469DE2 FOREIGN KEY (category_id) REFERENCES forum_category (id)');
        $this->addSql('ALTER TABLE forum_topic ADD CONSTRAINT FK_853478CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_853478CC12469DE2 ON forum_topic (category_id)');
        $this->addSql('CREATE INDEX IDX_853478CCA76ED395 ON forum_topic (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE forum_category ADD last_post DATETIME DEFAULT NULL, ADD last_post_id INT DEFAULT NULL, ADD last_poster_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forum_post DROP FOREIGN KEY FK_996BCC5A1F55203D');
        $this->addSql('ALTER TABLE forum_post DROP FOREIGN KEY FK_996BCC5AA76ED395');
        $this->addSql('DROP INDEX IDX_996BCC5A1F55203D ON forum_post');
        $this->addSql('DROP INDEX IDX_996BCC5AA76ED395 ON forum_post');
        $this->addSql('ALTER TABLE forum_post ADD edit_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forum_topic DROP FOREIGN KEY FK_853478CC12469DE2');
        $this->addSql('ALTER TABLE forum_topic DROP FOREIGN KEY FK_853478CCA76ED395');
        $this->addSql('DROP INDEX IDX_853478CC12469DE2 ON forum_topic');
        $this->addSql('DROP INDEX IDX_853478CCA76ED395 ON forum_topic');
        $this->addSql('ALTER TABLE forum_topic ADD last_post_id INT DEFAULT NULL');
    }
}
