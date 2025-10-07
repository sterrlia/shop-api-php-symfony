<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template T of object
 *
 * @template-extends ServiceEntityRepository<T>
 **/
abstract class AbstractEntityRepository extends ServiceEntityRepository
{
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
        $tableName = $this->getClassMetadata()->getTableName();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $sql = "SELECT id FROM `$tableName` WHERE id IN ($placeholders)";
        $conn = $this->getEntityManager()->getConnection();

        /** @var array<int|string, int|string> $existing */
        $existing = $conn->fetchFirstColumn($sql, $ids);

        $existing = array_map(static fn ($id) => (int) $id, $existing);

        return array_values(array_diff($ids, $existing));
    }
}
