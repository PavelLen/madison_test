<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180225215120 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE price_for_the_period (id INT AUTO_INCREMENT NOT NULL, product_price_period_modification_id INT DEFAULT NULL, date_from DATETIME NOT NULL, date_to DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, INDEX IDX_358DBFB4541F0D3B (product_price_period_modification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, gender VARCHAR(10) NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, currency VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_modification (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, color VARCHAR(100) NOT NULL, size VARCHAR(100) NOT NULL, vendor_code VARCHAR(100) NOT NULL, INDEX IDX_62C007B94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price_for_the_period ADD CONSTRAINT FK_358DBFB4541F0D3B FOREIGN KEY (product_price_period_modification_id) REFERENCES product_modification (id)');
        $this->addSql('ALTER TABLE product_modification ADD CONSTRAINT FK_62C007B94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_modification DROP FOREIGN KEY FK_62C007B94584665A');
        $this->addSql('ALTER TABLE price_for_the_period DROP FOREIGN KEY FK_358DBFB4541F0D3B');
        $this->addSql('DROP TABLE price_for_the_period');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_modification');
    }
}
