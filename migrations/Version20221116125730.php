<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116125730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders CHANGE status status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pizza DROP FOREIGN KEY pizza_ibfk_1');
        $this->addSql('DROP INDEX category_id_2 ON pizza');
        $this->addSql('DROP INDEX category_id ON pizza');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders CHANGE status status VARCHAR(255) DEFAULT \'To Do\' NOT NULL');
        $this->addSql('ALTER TABLE pizza ADD CONSTRAINT pizza_ibfk_1 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX category_id_2 ON pizza (category_id)');
        $this->addSql('CREATE INDEX category_id ON pizza (category_id)');
    }
}
