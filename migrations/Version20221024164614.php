<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024164614 extends AbstractMigration
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
        $this->addSql('ALTER TABLE pizza DROP FOREIGN KEY pizza_ibfk_1');
        $this->addSql('DROP INDEX category_id ON pizza');
        $this->addSql('ALTER TABLE pizza ADD img VARCHAR(255) NOT NULL, CHANGE price price VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT orders_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX user_id ON orders (user_id)');
        $this->addSql('ALTER TABLE pizza DROP img, CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE pizza ADD CONSTRAINT pizza_ibfk_1 FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX category_id ON pizza (category_id)');
    }
}
