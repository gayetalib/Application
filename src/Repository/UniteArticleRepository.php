<?php

namespace App\Repository;

use App\Entity\UniteArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UniteArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniteArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniteArticle[]    findAll()
 * @method UniteArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniteArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UniteArticle::class);
    }

    // /**
    //  * @return UniteArticle[] Returns an array of UniteArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UniteArticle
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
