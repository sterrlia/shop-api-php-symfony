<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\ProductPrice;
use App\Domain\ProductPriceDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductPrice>
 */
class ProductPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPrice::class);
    }

    public function updatePrice(
        ProductPriceDto $price,
    ): void {
        $conn = $this->getEntityManager()->getConnection();

        $sql = <<<SQL
            insert into product_price (product_id, region_id, purchase_price, sell_price, discounted_price)
            values (:product_id, :region_id, :purchase_price, :sell_price, :discounted_price)
            on conflict (product_id, region_id)
            do update set
                purchase_price = EXCLUDED.purchase_price,
                sell_price = EXCLUDED.sell_price,
                discounted_price = EXCLUDED.discounted_price
        SQL;

        $conn->executeStatement($sql, [
            'product_id' => $price->productId,
            'region_id' => $price->regionId,
            'purchase_price' => $price->purchasePrice,
            'sell_price' => $price->sellPrice,
            'discounted_price' => $price->discountedPrice,
        ]);
    }
}
