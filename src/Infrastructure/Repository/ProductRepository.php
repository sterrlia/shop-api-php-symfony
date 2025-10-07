<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractEntityRepository<Product>
 */
class ProductRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
}
