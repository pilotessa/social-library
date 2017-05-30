<?php

namespace LibraryBundle\Repository;

/**
 * BookRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRelatedBooks(\LibraryBundle\Entity\Book $book) {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomStringFunction('RAND', 'DoctrineExtensions\Query\Mysql\Rand');

        $genres = [];
        foreach ($book->getGenres() as $genre) {
            $genres[] = $genre->getId();
        }

        return $this->createQueryBuilder('book')
            ->innerJoin('book.genres', 'genres')
            ->where('book.id <> :id')
            ->andWhere('genres.id IN (:genres)')
            ->andWhere('book.status = :status')
            ->setParameter('id', $book->getId())
            ->setParameter('genres', $genres)
            ->setParameter('status', 'Published')
            ->orderBy('RAND()')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
}
