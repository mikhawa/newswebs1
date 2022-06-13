<?php

namespace App\Repository;

use App\Entity\Thesection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Thesection>
 *
 * @method Thesection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thesection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thesection[]    findAll()
 * @method Thesection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThesectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thesection::class);
    }

    public function add(Thesection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Thesection $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function selectAllSection():array{
        return $this->createQueryBuilder('l')
           ->orderBy('l.thesectiontitle', 'ASC')
           ->getQuery()
          ->getResult()
        ;
    }

//    /**
//     * @return Thesection[] Returns an array of Thesection objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Thesection
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
