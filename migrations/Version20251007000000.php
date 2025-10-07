
<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251007000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create product, region, and product_price tables with relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE region (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )
        SQL);

        $this->addSql(<<<SQL
            CREATE TABLE product (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )
        SQL);

        $this->addSql(<<<SQL
            CREATE TABLE product_price (
                id SERIAL PRIMARY KEY,
                product_id INT NOT NULL,
                region_id INT NOT NULL,
                purchase_price INT NOT NULL,
                sell_price INT NOT NULL,
                discounted_price INT NOT NULL,
                CONSTRAINT fk_product FOREIGN KEY(product_id) REFERENCES product(id) ON DELETE CASCADE,
                CONSTRAINT fk_region FOREIGN KEY(region_id) REFERENCES region(id) ON DELETE CASCADE
            )
        SQL);

        $this->addSql('CREATE UNIQUE INDEX idx_product_region_unique ON product_price(product_id, region_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product_price');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE region');
    }
}
