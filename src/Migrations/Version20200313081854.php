<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313081854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) DEFAULT NULL, reference_stock VARCHAR(255) NOT NULL, ini_qty INT NOT NULL, min_qty INT NOT NULL, created_at DATE NOT NULL, UNIQUE INDEX UNIQ_23A0E669D973670 (reference_stock), INDEX IDX_23A0E6612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commission (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_1C6501588C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, object VARCHAR(255) NOT NULL, phone INT DEFAULT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, date DATE NOT NULL, tranche VARCHAR(255) DEFAULT NULL, INDEX IDX_428D79732ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, activity VARCHAR(255) NOT NULL, phone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exitt (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, date DATE NOT NULL, number VARCHAR(255) NOT NULL, total_price NUMERIC(15, 3) NOT NULL, INDEX IDX_62467E2B8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution (id INT AUTO_INCREMENT NOT NULL, ministry VARCHAR(255) NOT NULL, office VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, director VARCHAR(255) NOT NULL, economist VARCHAR(255) NOT NULL, administrator VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone INT NOT NULL, fax INT NOT NULL, year VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, inv_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE journal (id INT AUTO_INCREMENT NOT NULL, exitt_id INT NOT NULL, nb_meal_id INT NOT NULL, date DATE NOT NULL, unit_cost NUMERIC(15, 3) NOT NULL, remarque LONGTEXT NOT NULL, total_costs NUMERIC(15, 3) NOT NULL, total_meals INT NOT NULL, INDEX IDX_C1A7E74D7C5ADC8E (exitt_id), INDEX IDX_C1A7E74D2CCDAD55 (nb_meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_demand (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, demand_id INT NOT NULL, quantity INT NOT NULL, remarque VARCHAR(255) DEFAULT NULL, INDEX IDX_36C32FCE7294869C (article_id), INDEX IDX_36C32FCE5D022E59 (demand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_exitt (id INT AUTO_INCREMENT NOT NULL, exitt_id INT NOT NULL, article_id INT DEFAULT NULL, quantity INT NOT NULL, unit_price NUMERIC(15, 3) NOT NULL, INDEX IDX_9DC259A87C5ADC8E (exitt_id), INDEX IDX_9DC259A87294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_exitt_line_stock (line_exitt_id INT NOT NULL, line_stock_id INT NOT NULL, INDEX IDX_FBF2FDFAAF398CF4 (line_exitt_id), INDEX IDX_FBF2FDFADEAE316A (line_stock_id), PRIMARY KEY(line_exitt_id, line_stock_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_inventory (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, inventory_id INT NOT NULL, line_stock_id INT NOT NULL, qty_inv INT NOT NULL, INDEX IDX_12EB1447294869C (article_id), INDEX IDX_12EB1449EEA759 (inventory_id), INDEX IDX_12EB144DEAE316A (line_stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_purchase (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, purchase_id INT NOT NULL, quantity_delivred INT NOT NULL, unit_price NUMERIC(15, 3) NOT NULL, tax INT NOT NULL, quantity_required INT DEFAULT NULL, technical_confirmity TINYINT(1) DEFAULT NULL, remarque VARCHAR(255) DEFAULT NULL, total_price NUMERIC(15, 3) NOT NULL, production VARCHAR(255) DEFAULT NULL, validation VARCHAR(255) DEFAULT NULL, INDEX IDX_B27481417294869C (article_id), INDEX IDX_B2748141558FBEB9 (purchase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_stock (id INT AUTO_INCREMENT NOT NULL, line_purchase_id INT NOT NULL, stock_id INT NOT NULL, qty_update INT NOT NULL, old_qty INT NOT NULL, quantity_alerte INT NOT NULL, valid_date DATE DEFAULT NULL, prod_date DATE DEFAULT NULL, reference VARCHAR(255) NOT NULL, date DATE NOT NULL, unit_price NUMERIC(15, 3) NOT NULL, INDEX IDX_B4B271E362E93E5A (line_purchase_id), INDEX IDX_B4B271E3DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(255) NOT NULL, breakfast VARCHAR(255) NOT NULL, lunch VARCHAR(255) NOT NULL, dinner VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7D053A93E5A02990 (day), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nb_meal (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, std_resident INT DEFAULT NULL, std_semi_resident INT DEFAULT NULL, std_granted INT DEFAULT NULL, professor INT DEFAULT NULL, employee INT DEFAULT NULL, curators INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, supplier_id INT NOT NULL, number VARCHAR(255) NOT NULL, date DATE NOT NULL, total_price NUMERIC(15, 3) NOT NULL, INDEX IDX_6117D13B8C03F15C (employee_id), INDEX IDX_6117D13B2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, activity VARCHAR(255) NOT NULL, tax_number VARCHAR(255) DEFAULT NULL, phone INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, UNIQUE INDEX UNIQ_9B2A6C7EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, director VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE commission ADD CONSTRAINT FK_1C6501588C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE demand ADD CONSTRAINT FK_428D79732ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE exitt ADD CONSTRAINT FK_62467E2B8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE journal ADD CONSTRAINT FK_C1A7E74D7C5ADC8E FOREIGN KEY (exitt_id) REFERENCES exitt (id)');
        $this->addSql('ALTER TABLE journal ADD CONSTRAINT FK_C1A7E74D2CCDAD55 FOREIGN KEY (nb_meal_id) REFERENCES nb_meal (id)');
        $this->addSql('ALTER TABLE line_demand ADD CONSTRAINT FK_36C32FCE7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE line_demand ADD CONSTRAINT FK_36C32FCE5D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id)');
        $this->addSql('ALTER TABLE line_exitt ADD CONSTRAINT FK_9DC259A87C5ADC8E FOREIGN KEY (exitt_id) REFERENCES exitt (id)');
        $this->addSql('ALTER TABLE line_exitt ADD CONSTRAINT FK_9DC259A87294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE line_exitt_line_stock ADD CONSTRAINT FK_FBF2FDFAAF398CF4 FOREIGN KEY (line_exitt_id) REFERENCES line_exitt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE line_exitt_line_stock ADD CONSTRAINT FK_FBF2FDFADEAE316A FOREIGN KEY (line_stock_id) REFERENCES line_stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE line_inventory ADD CONSTRAINT FK_12EB1447294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE line_inventory ADD CONSTRAINT FK_12EB1449EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE line_inventory ADD CONSTRAINT FK_12EB144DEAE316A FOREIGN KEY (line_stock_id) REFERENCES line_stock (id)');
        $this->addSql('ALTER TABLE line_purchase ADD CONSTRAINT FK_B27481417294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE line_purchase ADD CONSTRAINT FK_B2748141558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE line_stock ADD CONSTRAINT FK_B4B271E362E93E5A FOREIGN KEY (line_purchase_id) REFERENCES line_purchase (id)');
        $this->addSql('ALTER TABLE line_stock ADD CONSTRAINT FK_B4B271E3DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE line_demand DROP FOREIGN KEY FK_36C32FCE7294869C');
        $this->addSql('ALTER TABLE line_exitt DROP FOREIGN KEY FK_9DC259A87294869C');
        $this->addSql('ALTER TABLE line_inventory DROP FOREIGN KEY FK_12EB1447294869C');
        $this->addSql('ALTER TABLE line_purchase DROP FOREIGN KEY FK_B27481417294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE line_demand DROP FOREIGN KEY FK_36C32FCE5D022E59');
        $this->addSql('ALTER TABLE commission DROP FOREIGN KEY FK_1C6501588C03F15C');
        $this->addSql('ALTER TABLE exitt DROP FOREIGN KEY FK_62467E2B8C03F15C');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B8C03F15C');
        $this->addSql('ALTER TABLE journal DROP FOREIGN KEY FK_C1A7E74D7C5ADC8E');
        $this->addSql('ALTER TABLE line_exitt DROP FOREIGN KEY FK_9DC259A87C5ADC8E');
        $this->addSql('ALTER TABLE line_inventory DROP FOREIGN KEY FK_12EB1449EEA759');
        $this->addSql('ALTER TABLE line_exitt_line_stock DROP FOREIGN KEY FK_FBF2FDFAAF398CF4');
        $this->addSql('ALTER TABLE line_stock DROP FOREIGN KEY FK_B4B271E362E93E5A');
        $this->addSql('ALTER TABLE line_exitt_line_stock DROP FOREIGN KEY FK_FBF2FDFADEAE316A');
        $this->addSql('ALTER TABLE line_inventory DROP FOREIGN KEY FK_12EB144DEAE316A');
        $this->addSql('ALTER TABLE journal DROP FOREIGN KEY FK_C1A7E74D2CCDAD55');
        $this->addSql('ALTER TABLE line_purchase DROP FOREIGN KEY FK_B2748141558FBEB9');
        $this->addSql('ALTER TABLE line_stock DROP FOREIGN KEY FK_B4B271E3DCD6110');
        $this->addSql('ALTER TABLE demand DROP FOREIGN KEY FK_428D79732ADD6D8C');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B2ADD6D8C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE commission');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE demand');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE exitt');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE journal');
        $this->addSql('DROP TABLE line_demand');
        $this->addSql('DROP TABLE line_exitt');
        $this->addSql('DROP TABLE line_exitt_line_stock');
        $this->addSql('DROP TABLE line_inventory');
        $this->addSql('DROP TABLE line_purchase');
        $this->addSql('DROP TABLE line_stock');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE nb_meal');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE user');
    }
}
