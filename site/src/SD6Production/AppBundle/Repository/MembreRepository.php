<?php

namespace SD6Production\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
* MembreRepository
*
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class MembreRepository extends EntityRepository
{
	public function getMembre(){
		/*$qb = $this->createQueryBuilder('i');

		$qb
		->join('i.categories', 'cat')
		->addSelect('cat');

		$qb->where('cat.name = :catGalerie')
		->setParameter('catGalerie', 'Galerie');

		$qb->orderBy('i.id', 'DESC');

		return $qb
		->getQuery()
		->getResult();*/
	}
}
