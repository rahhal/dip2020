<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191225100051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL, CHANGE unit unit VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE amount_allocated amount_allocated NUMERIC(15, 3) DEFAULT NULL');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_request_supplied CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nb_meal CHANGE std_resident std_resident INT DEFAULT NULL, CHANGE std_semi_resident std_semi_resident INT DEFAULT NULL, CHANGE std_granted std_granted INT DEFAULT NULL, CHANGE professor professor INT DEFAULT NULL, CHANGE employee employee INT DEFAULT NULL, CHANGE curators curators INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE company company VARCHAR(255) DEFAULT NULL, CHANGE director director VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE fullname fullname VARCHAR(255) DEFAULT NULL, CHANGE rib rib VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL, CHANGE unit unit VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE category CHANGE amount_allocated amount_allocated NUMERIC(15, 3) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_request_supplied CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nb_meal CHANGE std_resident std_resident INT NOT NULL, CHANGE std_semi_resident std_semi_resident INT NOT NULL, CHANGE std_granted std_granted INT NOT NULL, CHANGE professor professor INT NOT NULL, CHANGE employee employee INT NOT NULL, CHANGE curators curators INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE company company VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE director director VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE fullname fullname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE rib rib VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
