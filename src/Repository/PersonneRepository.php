<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

//    /**
//     * @return Personne[] Returns an array of Personne objects
//     */
   public function FindPersonneByInterval ($ageMin,$ageMax)
   {
            $qb=$this->createQueryBuilder(alias:'p');

            return  $qb->getQuery()->getResult();

        ;
    }

    public function StatsPersonneByInterval ($ageMin,$ageMax)
    {
         
            $qb =$this->createQueryBuilder(alias:'p')
            ->Select(select:'avg(p.age) as ageMoyen,count(p.id) as nombrePersonne');
            $this->addIntervalAge($qb, $ageMin,$ageMax);
        
             return $qb->getQuery()->getScalarResult();
 
         ;
     }

     private function addIntervalAge(ORMQueryBuilder $qb , $ageMin, $ageMax ){
        $qb->andWhere('p.age >= :ageMin AND p.age  <=:ageMax')
        ->setParameter('ageMin', $ageMin)
        ->setParameter('ageMax', $ageMax);

     }

//    public function findOneBySomeField($value): ?Personne
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
