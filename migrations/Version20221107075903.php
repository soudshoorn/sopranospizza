<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221107075903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY orders_ibfk_1');
        $this->addSql('DROP INDEX user_id ON orders');
        $this->addSql('ALTER TABLE orders ADD status VARCHAR(255) NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD adress VARCHAR(255) NOT NULL, ADD postal VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD paymethod VARCHAR(255) NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE pizza DROP FOREIGN KEY pizza_ibfk_1');
        $this->addSql('DROP INDEX category_id ON pizza');
        $this->addSql('ALTER TABLE pizza CHANGE price price DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP status, DROP name, DROP adress, DROP postal, DROP email, DROP paymethod, CHANGE price price INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT orders_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX user_id ON orders (user_id)');
        $this->addSql('ALTER TABLE pizza CHANGE price price VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pizza ADD CONSTRAINT pizza_ibfk_1 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX category_id ON pizza (category_id)');
    }
}
