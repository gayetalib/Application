<?php

namespace App\Repository;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @$etat
    //  * @return Article[] Returns an array of Article objects
    //  */
    //     public function findEtatArticle($etat)
    // {
    //     return $this->createQueryBuilder('a')
    //         ->andWhere('a.etat = :0')
    //         ->setParameter('a', $etat)
    //         ->orderBy('a.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }


    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

     
        public function findEtatArticle($etat): array
       {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Article a 
            WHERE  a.etat = 0
            ORDER BY a.etat ASC'
        );
        $req=$query->getResult();
     
        return $req;

      }

        public function findDebloqueArticle($etat): array
        {  
            
            $entityManager = $this->getEntityManager();

            $query = $entityManager->createQuery(
                'SELECT a
                FROM App\Entity\Article a 
                WHERE  a.etat = 1
                ORDER BY a.etat ASC'
            );
            $req=$query->getResult();
        
            // returns an array of Product objects
            return $req;

        

        }
}