<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191231071915 extends AbstractMigration
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
        $this->addSql('ALTER TABLE line_exitt DROP unit_price, DROP tax, DROP total_price, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_request_supplied CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nb_meal CHANGE std_resident std_resident INT DEFAULT NULL, CHANGE std_semi_resident std_semi_resident INT DEFAULT NULL, CHANGE std_granted std_granted INT DEFAULT NULL, CHANGE professor professor INT DEFAULT NULL, CHANGE employee employee INT DEFAULT NULL, CHANGE curators curators INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request_supplied CHANGE date date DATE DEFAULT NULL, CHANGE tranche tranche VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier CHANGE tax_number tax_number VARCHAR(255) DEFAULT NULL, CHANGE phone phone INT DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE company company VARCHAR(255) DEFAULT NULL, CHANGE director director VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE fullname fullname VARCHAR(255) DEFAULT NULL, CHANGE rib rib VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL, CHANGE unit unit VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE category CHANGE amount_allocated amount_allocated NUMERIC(15, 3) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE line_exitt ADD unit_price NUMERIC(15, 3) NOT NULL, ADD tax INT NOT NULL, ADD total_price NUMERIC(15, 3) NOT NULL, CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_request_supplied CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nb_meal CHANGE std_resident std_resident INT DEFAULT NULL, CHANGE std_semi_resident std_semi_resident INT DEFAULT NULL, CHANGE std_granted std_granted INT DEFAULT NULL, CHANGE professor professor INT DEFAULT NULL, CHANGE employee employee INT DEFAULT NULL, CHANGE curators curators INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request_supplied CHANGE date date DATE DEFAULT \'NULL\', CHANGE tranche tranche VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE supplier CHANGE tax_number tax_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone INT DEFAULT NULL, CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE company company VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE director director VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE fullname fullname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE rib rib VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
