<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }
    public function findDistinctGenres()
    {
        return $this->createQueryBuilder('g')
            ->select('DISTINCT g.genres')
            ->getQuery()
            ->getResult();
    }

    public function findDistinctPlatforms()
    {
        return $this->createQueryBuilder('g')
            ->select('DISTINCT g.platform')
            ->getQuery()
            ->getResult();
    }

    public function findBestGames()
    {
        /*
                //en DQL
                $entityManager = $this->getEntityManager();
                $dql = "
                    SELECT g
                    FROM App\Entity\Game g
                    WHERE g.vote > 8
                    ORDER BY g.vote DESC
                ";

                $query = $entityManager->createQuery($dql);
                $results = $query->getResult();

                dump($results);
                return $results;
        */

        //Version QueryBuilder
        $queryBuilder = $this->createQueryBuilder('g');

        $queryBuilder->leftJoin('g.walkthroughs', 'walk')
            ->addSelect('walk');

        $queryBuilder->andWhere('g.vote > 5');
        $queryBuilder->addOrderBy('g.vote', 'DESC');
        $query = $queryBuilder->getQuery();

        $query -> setMaxResults(25);

        $paginator = new Paginator($query);
        return $paginator;

    }
    public function add(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /*  public function filtre(PropertySearch $propertySearch)
      {

          $query = $this->createQueryBuilder('g');

          $query->andWhere('g.genres = :genres')
              ->setParameter('genres', $propertySearch->getGenres());
          }*/
    public function filtre(PropertySearch $propertySearch)
    {
        $query = $this->createQueryBuilder('g');

        if ($propertySearch->getGenres()) {
            $query->andWhere('g.genres = :genres')
                ->setParameter('genres', $propertySearch->getGenres());
        }

        if ($propertySearch->getPlatform()) {
            $query->andWhere('g.platform = :platform')
                ->setParameter('platform', $propertySearch->getPlatform());
        }

        // Ajoutez d'autres conditions de filtrage facultatives ici si nÃ©cessaire

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Game[] Returns an array of Game objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Game
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
