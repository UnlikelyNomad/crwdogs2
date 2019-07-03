<?php

namespace App\Repository;

use App\Entity\ForumTopic;
use App\Entity\ForumCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ForumTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumTopic[]    findAll()
 * @method ForumTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumTopicRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ForumTopic::class);
    }

    // /**
    //  * @return ForumTopic[] Returns an array of ForumTopic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ForumTopic
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function pagedTopics(ForumCategory $category, $page, $topicsPerPage) {

        $first = ($page - 1) * $topicsPerPage;

        $page = $this->createQueryBuilder('t')
        ->andWhere('t.category = :cat')
        ->setParameter('cat', $category)
        ->orderBy('t.last_post', 'DESC')
        ->setFirstResult($first)
        ->setMaxResults($topicsPerPage)
        ->getQuery()->getResult();

        return $page;
    }

    public function latestForCategory(ForumCategory $category) {
        return $this->createQueryBuilder('t')
        ->where('t.category = :cat')
        ->setParameter('cat', $category)
        ->orderBy('t.last_post', 'DESC')
        ->setMaxResults(1)
        ->getQuery()->getOneOrNullResult();
    }
}
