<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127094114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE line_stock_line_exitt (line_stock_id INT NOT NULL, line_exitt_id INT NOT NULL, INDEX IDX_6DFBB296DEAE316A (line_stock_id), INDEX IDX_6DFBB296AF398CF4 (line_exitt_id), PRIMARY KEY(line_stock_id, line_exitt_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_stock_line_exitt ADD CONSTRAINT FK_6DFBB296DEAE316A FOREIGN KEY (line_stock_id) REFERENCES line_stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE line_stock_line_exitt ADD CONSTRAINT FK_6DFBB296AF398CF4 FOREIGN KEY (line_exitt_id) REFERENCES line_exitt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE line_stock CHANGE valid_date valid_date DATE DEFAULT NULL, CHANGE prod_date prod_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL, CHANGE unit unit VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE amount_allocated amount_allocated NUMERIC(15, 3) DEFAULT NULL');
        $this->addSql('ALTER TABLE demand CHANGE tranche tranche VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory CHANGE inv_number inv_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE line_demand CHANGE remarque remarque VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL, CHANGE quantity_required quantity_required INT DEFAULT NULL, CHANGE technical_confirmity technical_confirmity TINYINT(1) DEFAULT NULL, CHANGE remarque remarque VARCHAR(255) DEFAULT NULL, CHANGE production production VARCHAR(255) DEFAULT NULL, CHANGE validation validation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier CHANGE tax_number tax_number VARCHAR(255) DEFAULT NULL, CHANGE phone phone INT DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE contact CHANGE phone phone INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nb_meal CHANGE std_resident std_resident INT DEFAULT NULL, CHANGE std_semi_resident std_semi_resident INT DEFAULT NULL, CHANGE std_granted std_granted INT DEFAULT NULL, CHANGE professor professor INT DEFAULT NULL, CHANGE employee employee INT DEFAULT NULL, CHANGE curators curators INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE company company VARCHAR(255) DEFAULT NULL, CHANGE director director VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE fullname fullname VARCHAR(255) DEFAULT NULL, CHANGE rib rib VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE line_stock_line_exitt');
        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL, CHANGE unit unit VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE category CHANGE amount_allocated amount_allocated NUMERIC(15, 3) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE contact CHANGE phone phone INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demand CHANGE tranche tranche VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE inventory CHANGE inv_number inv_number VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE line_demand CHANGE remarque remarque VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE line_exitt CHANGE article_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_purchase CHANGE article_id article_id INT DEFAULT NULL, CHANGE quantity_required quantity_required INT DEFAULT NULL, CHANGE technical_confirmity technical_confirmity TINYINT(1) DEFAULT \'NULL\', CHANGE remarque remarque VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE production production VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE validation validation VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE line_stock CHANGE valid_date valid_date DATE DEFAULT \'NULL\', CHANGE prod_date prod_date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE nb_meal CHANGE std_resident std_resident INT DEFAULT NULL, CHANGE std_semi_resident std_semi_resident INT DEFAULT NULL, CHANGE std_granted std_granted INT DEFAULT NULL, CHANGE professor professor INT DEFAULT NULL, CHANGE employee employee INT DEFAULT NULL, CHANGE curators curators INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supplier CHANGE tax_number tax_number VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE phone phone INT DEFAULT NULL, CHANGE address address VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE email email VARCHAR(180) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE company company VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE director director VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE city city VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE fullname fullname VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`, CHANGE rib rib VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_unicode_ci`');
    }
}
