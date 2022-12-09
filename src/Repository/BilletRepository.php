<?php

namespace App\Repository;

use App\Entity\Billet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Billet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billet[]    findAll()
 * @method Billet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billet::class);
    }

    public function getCountBilletRestant($journee)
    {
        return $this->createQueryBuilder('b')
            ->select('count(b.id)')
            ->andWhere('b.journee = :journee')
            ->andWhere('b.panier is null')
            ->andWhere('b.user is null')
            ->groupBy('b.categorie')
            ->setParameter('journee', $journee)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function getBilletRestantGradin($journee, $gradin)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.journee = :journee')
            ->andWhere('b.categorie = :gradin')
            ->andWhere('b.panier is null')
            ->andWhere('b.user is null')
            ->setParameter('journee', $journee)
            ->setParameter('gradin', $gradin)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneBilletRestantGradin($journee, $gradin)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.journee = :journee')
            ->andWhere('b.categorie = :gradin')
            ->andWhere('b.panier is null')
            ->andWhere('b.user is null')
            ->setMaxResults(1)
            ->setParameter('journee', $journee)
            ->setParameter('gradin', $gradin)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Billet
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
