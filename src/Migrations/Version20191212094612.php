<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191212094612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C136ABA6B8');
        $this->addSql('DROP INDEX IDX_64C19C136ABA6B8 ON category');
        $this->addSql('ALTER TABLE category DROP budget_id');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL, CHANGE production production VARCHAR(255) DEFAULT NULL, CHANGE validation validation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD budget_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C136ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('CREATE INDEX IDX_64C19C136ABA6B8 ON category (budget_id)');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL, CHANGE production production VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE validation validation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
