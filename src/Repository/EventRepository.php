<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Event|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Event|null findOneBy( array $criteria, array $orderBy = null )
 * @method Event[]    findAll()
 * @method Event[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class EventRepository extends ServiceEntityRepository {
	public function __construct( RegistryInterface $registry ) {
		parent::__construct( $registry, Event::class );
	}

	/**
	 * Returns last events
	 *
	 * @param $limit
	 * @param int $start
	 *
	 * @return mixed
	 */
	public function findLasts( $limit, $start = 0 ) {

		return $this->createQueryBuilder( 'e' )
		            ->addSelect( 'e' )
		            ->where( 'e.published = 1' )
		            ->orderBy( 'e.added', 'DESC' )
		            ->setFirstResult( $start )
		            ->setMaxResults( $limit )
		            ->getQuery()
		            ->execute();
	}

	public function countPublished() {

		return $this->getEntityManager()->createQuery(
			'SELECT COUNT(e)
			FROM App\Entity\Event e
			WHERE e.published = 1'
		)
		            ->getSingleScalarResult();

	}

	public function countBooking() {
		return $this->getEntityManager()->createQuery(
			'SELECT e event, COUNT(b) as count
			FROM App\Entity\Event e
			LEFT JOIN e.bookings b
			ORDER BY e.added DESC'
		)
		            ->getSingleResult();
	}
}
