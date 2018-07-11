<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Validator\Constraints\Date;

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

	public function findLast() {
		return $this->createQueryBuilder('e')
			->addSelect('e')
			->orderBy('e.added', 'DESC')
			->getQuery()
			->setMaxResults(1)
			->execute()[0];
	}

	public function findNext() {

		$now = new \DateTime();

		return $this->createQueryBuilder('e')
			->addSelect('e')
			->where('e.added >= :now')
			->andWhere('e.published = 1')
			->orderBy('e.added', 'ASC')
			->setMaxResults(1)
			->setParameter('now', $now)
			->getQuery()
			->execute()[0];
	}
}
