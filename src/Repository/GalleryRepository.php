<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Gallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Gallery|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Gallery|null findOneBy( array $criteria, array $orderBy = null )
 * @method Gallery[]    findAll()
 * @method Gallery[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class GalleryRepository extends ServiceEntityRepository {
	public function __construct( RegistryInterface $registry ) {
		parent::__construct( $registry, Gallery::class );
	}


	public function findLasts( $limit, $start = 0 ) {

		$qb = $this->createQueryBuilder( 'g' )
		           ->addSelect( 'g' )
		           ->innerJoin( 'g.pictures', 'p' )
		           ->where( 'g.published = 1' )
		           ->andwhere( 'p.gallery is not null' )
		           ->orderBy( 'g.added', 'DESC' )
		           ->setFirstResult( $start )
		           ->setMaxResults( $limit );

		return new Paginator( $qb );

	}

	public function countPublished() {

		return $this->getEntityManager()->createQuery(
			'SELECT COUNT(g)
			FROM App\Entity\Gallery g
			WHERE g.published = 1'
		)
		            ->getSingleScalarResult();

	}

	public function countNotEmpty() {
		return $this->getEntityManager()->createQuery(
			'SELECT COUNT(p)
			FROM App\Entity\Image p
			 JOIN p.gallery g
			WHERE p.gallery is not null
			GROUP BY g'
		)
		            ->getResult();
	}


}
