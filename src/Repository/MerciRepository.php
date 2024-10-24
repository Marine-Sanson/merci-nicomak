<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Merci;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Merci>
 */
class MerciRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Merci::class);
    }

    public function save(Merci $merci): void
    {
        $this->getEntityManager()->persist($merci);
        $this->getEntityManager()->flush();
    }
    
    public function findAllOrderedByDate()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByAuthor(User $user)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.author = :user')
            ->setParameter('user', $user)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function deleteMerci(Merci $merci): void
    {
        $this->getEntityManager()->remove($merci);
        $this->getEntityManager()->flush();
    }


    //    /**
    //     * @return Merci[] Returns an array of Merci objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Merci
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
