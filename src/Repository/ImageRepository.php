<?php

namespace App\Repository;

use App\Entity\Gallery;
use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Image|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Image|null findOneBy( array $criteria, array $orderBy = null )
 * @method Image[]    findAll()
 * @method Image[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class ImageRepository extends ServiceEntityRepository {
	public function __construct( RegistryInterface $registry ) {
		parent::__construct( $registry, Image::class );
	}

	public function findPreviewGalleries() {

		return $this->createQueryBuilder( 'i' )
		            ->andWhere( 'i.gallery is not null' )
		            ->setFirstResult( 0 )
		            ->setMaxResults( 12 )
		            ->innerJoin( 'i.gallery', 'g' )
		            ->addSelect( 'g' )
		            ->groupBy( 'i.gallery' )
		            ->setFirstResult( 0 )
		            ->setMaxResults( 12 )
		            ->getQuery()
		            ->execute();

	}

	/**
	 * @param Gallery $gallery
	 * @param $firstResult
	 * @param int $maxResults
	 *
	 * @return Paginator
	 */
	public function getPictures( Gallery $gallery, $firstResult, $maxResults = 12 ) {


		return $this->createQueryBuilder( 'p' )
		            ->where( 'p.gallery = :id' )
		            ->setParameter( 'id', $gallery->getId() )
		            ->setFirstResult( $firstResult )
		            ->setMaxResults( $maxResults )
		            ->getQuery()
		            ->execute();

	}

	public function countGallery( Gallery $gallery ) {

		return $this->getEntityManager()->createQuery(
			'SELECT COUNT(p)
			FROM App\Entity\Image p
			WHERE p.gallery = :id'
		)
		            ->setParameter( 'id', $gallery->getId() )
		            ->getSingleScalarResult();
	}


	public function countTotalPictures() {
		return $this->getEntityManager()->createQuery(
			'SELECT COUNT(i)
			FROM App\Entity\Image i
			WHERE i.gallery is not null'
		)
		            ->getSingleScalarResult();


	}
//    /**
//     * @return Image[] Returns an array of Image objects
//     */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('i')
			->andWhere('i.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('i.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Image
	{
		return $this->createQueryBuilder('i')
			->andWhere('i.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}
