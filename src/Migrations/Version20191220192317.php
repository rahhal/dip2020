<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191220192317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE line_purchase ADD production DATE NOT NULL, ADD validation DATE NOT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_request_supplied CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase DROP production, DROP validation, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_request_supplied CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
