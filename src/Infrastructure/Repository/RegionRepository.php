<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Region>
 */
class RegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }

    /**
     * @param list<int> $ids
     *
     * @return int[]
     */
    public function findMissingIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $sql = "SELECT id FROM region WHERE id IN ($placeholders)";
        $conn = $this->getEntityManager()->getConnection();

        /** @var array<int|string, int|string> $existing */
        $existing = $conn->fetchFirstColumn($sql, $ids);

        $existing = array_map(static fn ($id) => (int) $id, $existing);

        return array_values(array_diff($ids, $existing));
    }
}
