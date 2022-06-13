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
    public function SelectAllArticlesBySectionID(int $idsection): array{
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , a.thearticleresume, a.thearticledate,
            u.idtheuser, u.theuserlogin,
            (SELECT COUNT(thecomment_idthecomment) FROM thearticle_has_thecomment WHERE thearticle_idthearticle = a.idthearticle) AS nbcomment,
            group_concat(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            group_concat(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                # Jointure MANY TO ONE
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                # Many TO Many mais avec une CONDITION WHERE qui ne permet
                # de garder qu'une seule rubrique AND sha.thesection_idthesection=
            INNER JOIN thesection_has_thearticle sha
                    ON sha.thearticle_idthearticle = a.idthearticle
                # Many to Many sur 2 tables pour garder toutes les rubriques
                INNER JOIN thesection_has_thearticle sha2
                    ON sha2.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s
                    ON sha2.thesection_idthesection = s.idthesection
                # conditions : article validé, utilisateur actif et
                # se trouver dans la section choisie
                WHERE a.thearticleactivate=1
        AND u.theuseractivate=1
        AND sha.thesection_idthesection=:idsection
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC;";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['idsection' => $idsection]);
        return $resultSet->fetchAllAssociative();
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
