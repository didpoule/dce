<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Formula;
use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Place;
use App\Entity\Post;
use App\Entity\Teammate;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture {
	public function load( ObjectManager $manager ) {

		// creation images
		for ( $i = 0; $i < 40; $i ++ ) {

			$images[] = $image = new Image();
			$image->setUrl( "http://localhost:8000/build/images/shows.8df69f5a.jpg" );
			$image->setAlt( 'image' );
			$manager->persist( $image );
		}

		//création catégories
		$posts = new Category();
		$posts->setName( 'posts' );

		$manager->persist( $posts );


		$services = new Category();
		$services->setName( 'services' );

		$manager->persist( $services );

		for ( $i = 0; $i < 3; $i ++ ) {
			$post = new Post();
			$post->setImage( $images[0] )
			     ->setPublished( true )
			     ->setAdded( new \DateTime() )
			     ->setTitle( 'Service ' . $i )
			     ->setCategory( $services )
			     ->setContent( 'Lorem ipsum' );

			$manager->persist( $post );
		}


		$manager->persist( $post );

		$club = new Category();
		$club->setName( 'club' );

		$manager->persist( $club );

		$post = new Post();
		$post->setImage( $images[0] )
		     ->setPublished( true )
		     ->setAdded( new \DateTime() )
		     ->setTitle( 'Le club' )
		     ->setCategory( $club )
		     ->setContent( 'Lorem ipsum' );

		$manager->persist( $post );


		// creation articles
		for ( $i = 0; $i < 10; $i ++ ) {

			$post = new Post();
			$post->setTitle( 'Article ' . $i )
			     ->setContent( 'Lorem Ipsum' )
			     ->setAdded( new \DateTime() )
			     ->setPublished( true )
			     ->setCategory( $posts )
			     ->setImage( $images[ $i ] );

			$manager->persist( $post );
		}

		// Création lieu
		$place = new Place();
		$place->setName( 'Welness Lyon Confluence' );
		$place->setAddress( '134 cours charlemagne, 690002 Lyon' );

		$manager->persist( $place );


		// Création formules


		// creation evenements
		for ( $i = 0; $i < 5; $i ++ ) {

			$event = new Event();
			$event->setTitle( 'Evenement ' . $i )
			      ->setContent( 'lorem ipsum' )
			      ->setAdded( new \DateTime() )
			      ->setPublished( true )
			      ->setImage( $images[ $i ] );

			$gallery = new Gallery();
			$gallery->setEvent( $event )->setPublished( true )
			        ->setAdded( new \DateTime() );

			$manager->persist( $gallery );


			$event->setGallery( $gallery )
			      ->setPlace( $place );

			for ( $j = 0; $j < 3; $j ++ ) {
				$formula = new Formula();
				$formula->setName( 'Formule ' . $j );
				$formula->setPrice( rand( 20, 40 ) );
				$formula->setEvent( $event );

				$event->addFormula( $formula );

				$manager->persist( $formula );


			}

			for ( $k = 0; $k < 13; $k ++ ) {
				$gallery->addPicture( $images[ $k ] );
			}

		}

		// Creation team

		for ( $i = 1; $i < 13; $i ++ ) {
			$image = new Image();
			$image->setUrl( sprintf( "http://localhost:8000/build/images/team/%s.jpg", $i ) );
			$image->setAlt( 'teammember' );

			$manager->persist( $image );

			$teammate = new Teammate();
			$teammate->setName( 'Membre numéro ' . $i );
			$teammate->setImage( $image );
			$teammate->setDescription( 'Role: test' );

			$manager->persist( $teammate );
		}

		for ( $i = 1; $i < 3; $i ++ ) {
			$user = new User();

			$user->setEmail( sprintf( '0%s@gmail.com', $i ) );
			$user->setPlainPassword( "password" );
			$user->setRoles(['ROLE_ADMIN']);

			$manager->persist( $user );
		}


		$manager->flush();
	}
}