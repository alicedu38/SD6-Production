<?php

namespace SD6Production\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AnnonceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnnonceRepository extends EntityRepository
{
	public function getAnnonceWithCategories(array $categorieNoms){
		$qb = $this->createQueryBuilder('a');

	    $qb
	      ->join('a.categories', 'cat')
	      ->addSelect('cat');

	    $qb->where($qb->expr()->in('cat.nom', $categorieNoms));

	    $qb->andWhere('a.publie = :publie')
	    	->setParameter('publie', true)
      		->orderBy('a.date', 'DESC');

	  	return $qb
	    	->getQuery()
	    	->getResult();
	}
}
