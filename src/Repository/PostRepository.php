<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Post|null findOneBy( array $criteria, array $orderBy = null )
 * @method Post[]    findAll()
 * @method Post[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class PostRepository extends ServiceEntityRepository {
	public function __construct( RegistryInterface $registry ) {
		parent::__construct( $registry, Post::class );
	}

	public function findService( $slug ) {

		return $this->createQueryBuilder( 'p' )
		            ->leftJoin( 'p.category', 'c' )
		            ->addSelect( 'c' )
		            ->where( 'c.name = :name' )
		            ->setParameter( 'name', 'services' )
		            ->andWhere( 'p.slug LIKE :slug' )
		            ->setParameter( 'slug', $slug )
		            ->getQuery()
		            ->getOneOrNullResult();
	}

	public function findClub() {

		$query = $this->createQueryBuilder( 'p' )
		              ->leftJoin( 'p.category', 'c' )
		              ->addSelect( 'c' )
		              ->where( 'c.name = :name' )
		              ->setParameter( 'name', 'club' )
		              ->getQuery()
		              ->execute();

		return $query[0];
	}

	public function findServices() {
		return $this->createQueryBuilder( 'p' )
		            ->leftJoin( 'p.category', 'c' )
		            ->addSelect( 'p' )
		            ->where( 'c.name = :category' )
		            ->setParameter( 'category', 'services' )
		            ->getQuery()
		            ->execute();
	}

	public function findLasts( $limit, $first = 0 ) {
		return $this->createQueryBuilder( 'p' )
		            ->leftJoin( 'p.category', 'c' )
		            ->addSelect( 'p' )
		            ->where( 'c.name = :category' )
		            ->setParameter( 'category', 'posts' )
		            ->setFirstResult( $first )
		            ->setMaxResults( $limit )
		            ->getQuery()
		            ->execute();
	}

	public function countPublished() {
		return $this->getEntityManager()->createQuery(
			'SELECT COUNT(p)
			FROM App\Entity\Post p
			 WHERE p.category IN (
			 SELECT c.id 
			 FROM App\Entity\Category c 
			 WHERE c.name = :category
			 )
			  AND p.published = 1'
		)
		            ->setParameter( 'category', 'posts' )
		            ->getSingleScalarResult();
	}
}
