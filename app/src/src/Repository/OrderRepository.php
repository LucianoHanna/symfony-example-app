<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

   /**
    * @return Order[] Returns an array of Order objects
    */
   public function findUndeliveredOrders(): array
   {
       return $this->createQueryBuilder('o')
           ->andWhere('o.deliveredAt IS NULL')
           ->orderBy('o.orderedAt', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
}
