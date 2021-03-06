<?php

namespace AppBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByCategory($value){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT a, c FROM AppBundle:Article a
                      JOIN a.categories c
                      WHERE c.title = :title'
            )->setParameter('title',$value);
        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
