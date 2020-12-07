<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param string $productUuid
     *
     * @return int
     */
    public function sumOrderedQuantity(string $productUuid): int
    {
        try {
            return (int)$this->createQueryBuilder('o')
                ->andWhere('o.productUuid = :product')
                ->setParameters(new ArrayCollection(
                    [
                        new Parameter('product', $productUuid, 'uuid'),
                    ]
                ))
                ->select('SUM(o.orderQuantity) as orderedQuantity')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (Throwable $e) {
            return 0;
        }
    }
}
