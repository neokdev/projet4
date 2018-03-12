<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180306115719 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, reducted_price TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, ticket_price VARCHAR(255) NOT NULL, ticket_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_order (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, order_date DATE NOT NULL, duration TINYINT(1) NOT NULL, ticket_collection LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', mail VARCHAR(255) DEFAULT NULL, order_price VARCHAR(255) NOT NULL, order_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_order');
    }
}
