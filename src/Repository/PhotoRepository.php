<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Photo>
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    public function findPortrait(): ?Photo
    {
        return $this->findOneBy(['estPortrait' => true]);
    }

    /**
     * Photos explicitly flagged for the homepage gallery (miseEnAvant).
     * Photos without a category or used as the "A propos" portrait are
     * never eligible, regardless of the flag. Ordered by position, with a
     * stable secondary sort by id since position is only meaningful within
     * a category and several featured photos can share the same value.
     *
     * @return Photo[]
     */
    public function findForPublicGallery(int $limit): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categorie IS NOT NULL')
            ->andWhere('p.estPortrait = false')
            ->andWhere('p.miseEnAvant = true')
            ->orderBy('p.position', 'ASC')
            ->addOrderBy('p.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Photo[] Returns an array of Photo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Photo
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
