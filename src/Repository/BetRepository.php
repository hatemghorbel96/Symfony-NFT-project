<?php

namespace App\Repository;

use App\Entity\Bet;
use App\Entity\User;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Bet>
 *
 * @method Bet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bet[]    findAll()
 * @method Bet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bet::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Bet $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Bet $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Bet[] Returns an array of Bet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bet
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function winersearch($id)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.post = :val')
            /* ->andWhere('MAX (p.devis) ') */
            ->setParameter('val', $id)
            ->Select('(p.user)')
            ->orderBy('p.devis','DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function winerob($id): ?User
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.post = :val')
            /* ->andWhere('MAX (p.devis) ') */
            
            ->setParameter('val', $id)
            ->join('p.user','u')
            ->Select('(p.user)')
            ->orderBy('p.devis','DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function bentent($id)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.post = :val')
            /* ->andWhere('MAX (p.devis) ') */
            ->setParameter('val', $id)
            ->Select('(p.user)')
            ->orderBy('p.devis','DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getMaxResults()
        ;
    }

 

}
