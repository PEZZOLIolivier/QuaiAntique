<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menu>
 *
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function save(Menu $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Menu $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getMenuQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('menu');
    }

    public function filterActive($queryBuilder, $activeValue): QueryBuilder {
        return $queryBuilder
            ->andWhere('menu.isPublish = :activeValue')
            ->setParameter('activeValue', $activeValue);
    }

    public function addOrderAsc($queryBuilder): QueryBuilder {
        return $queryBuilder
            ->orderBy('menu.name', 'ASC');
    }

    public function executeQuery($queryBuilder): array {
        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    public function getAllActiveMenu(): array {
        $qb = $this->getMenuQueryBuilder();
        $qb = $this->filterActive($qb, true);
        $qb = $this->addOrderAsc($qb);
        return $this->executeQuery($qb);
    }
}
