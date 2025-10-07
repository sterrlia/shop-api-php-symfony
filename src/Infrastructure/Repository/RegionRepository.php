<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Region;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractEntityRepository<Region>
 */
class RegionRepository extends AbstractEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }
}
