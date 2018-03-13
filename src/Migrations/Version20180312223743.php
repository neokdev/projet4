<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180312223743 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, ticket_order_id INT DEFAULT NULL, reduced_price TINYINT(1) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, ticket_price INT NOT NULL, ticket_number VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA38F691B9 (ticket_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_order (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, order_date DATE NOT NULL, duration TINYINT(1) NOT NULL, mail VARCHAR(255) DEFAULT NULL, order_price VARCHAR(255) NOT NULL, order_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38F691B9 FOREIGN KEY (ticket_order_id) REFERENCES ticket_order (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA38F691B9');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_order');
    }
}
