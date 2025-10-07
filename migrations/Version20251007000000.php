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
            create table region (
                id serial primary key,
                name varchar(255) not null
            )
        SQL);

        $this->addSql(<<<SQL
            create table product (
                id serial primary key,
                name varchar(255) not null
            )
        SQL);

        $this->addSql(<<<SQL
            create table product_price (
                id serial primary key,
                product_id int not null,
                region_id int not null,
                purchase_price int not null,
                sell_price int not null,
                discounted_price int not null,
                constraint fk_product FOREIGN key(product_id) references product(id) on delete cascade,
                constraint fk_region FOREIGN key(region_id) references region(id) on delete cascade
            )
        SQL);

        $this->addSql('CREATE UNIQUE INDEX idx_product_region_unique ON product_price(product_id, region_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table product_price');
        $this->addSql('drop table product');
        $this->addSql('drop table region');
    }
}
