<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180208154204 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customers ADD email VARCHAR(255) NOT NULL, ADD order_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE products ADD type VARCHAR(255) NOT NULL, ADD price VARCHAR(255) NOT NULL, ADD date VARCHAR(255) NOT NULL, ADD order_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD name VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL, ADD bithdate VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD order_number VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customers DROP email, DROP order_number');
        $this->addSql('ALTER TABLE products DROP type, DROP price, DROP date, DROP order_number');
        $this->addSql('ALTER TABLE users DROP name, DROP first_name, DROP country, DROP bithdate, DROP email, DROP order_number');
    }
}
