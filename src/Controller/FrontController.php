<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Post;
use App\Entity\Teammate;
use App\Form\BookingType;
use App\Form\ContactType;
use App\Handler\BookingHandler;
use App\Handler\ContactHandler;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FrontController extends Controller {

	/**
	 * @Route("/", name="front_home")
	 */
	public function homeAction() {

		return $this->render( 'front/home.html.twig', [
			'post' => $this->getDoctrine()->getRepository(Post::class)->findLastPost(),
			'services' => $this->getDoctrine()->getRepository(Post::class)->findServices()
		] );
	}

	/**
	 * @Route("/next_workshops/{limit}", name="front_next_events", requirements={"limit"="\d+"})
	 */
	public function nextWorkshopsAction( int $limit ) {

		return $this->render( 'front/next_workshops.html.twig', [
			'events' => $this->getDoctrine()->getRepository( Event::class )->findLasts( $limit )
		] );
	}

	public function lastGalleriesAction( int $limit ) {

		return $this->render( 'front/last_galleries.html.twig', [
			'galleries' => $this->getDoctrine()->getRepository( Gallery::class )->findLasts( $limit )
		] );
	}

	public function servicesAction() {

		return $this->render( 'front/services.html.twig', [
			'services' => $this->getDoctrine()->getRepository( Post::class )->findServices()
		] );
	}

	/**
	 * @Route("/news", name="front_posts")
	 */
	public function postsAction() {

		$count = $this->getDoctrine()->getRepository( Post::class )->countPublished();

		return $this->render( 'front/posts.html.twig', [
			'posts' => $this->getDoctrine()->getRepository( Post::class )->findLasts( MAX_PER_PAGE ),
			'count' => $count,
			'pages' => intval( ceil( $count / MAX_PER_PAGE ) )
		] );

	}

	/**
	 * @Route("/news/{slug}", name="front_post")
	 * @ParamConverter("post", class="App\Entity\Post")
	 */
	public function postAction( $post = null ) {

		if ( ! $post ) {
			return $this->redirectToRoute( 'front_404', [
				'message' => "L'article demandé n'existe pas."
			] );
		}

		return $this->render( 'front/post.html.twig', [
			'post' => $post
		] );
	}

	/**
	 * @Route("/team", name="front_team")
	 */
	public function teamAction() {

		return $this->render( 'front/team.html.twig', [
			'team' => $this->getDoctrine()->getManager()->getRepository( Teammate::class )->findAll()
		] );
	}

	/**
	 * @Route("/workshops", name="front_events")
	 */
	public function eventsAction() {

		$count = $this->getDoctrine()->getRepository( Event::class )->countPublished();

		return $this->render( 'front/events.html.twig', [
			'events' => $this->getDoctrine()->getRepository( Event::class )->findLasts( MAX_PER_PAGE ),
			'count'  => $count,
			'pages'  =>  intval( ceil( $count / MAX_PER_PAGE ) )
		] );
	}

	/**
	 * @Route("/workshop/{slug}", name="front_event")
	 * @ParamConverter("event", class="App\Entity\Event")
	 */
	public function eventAction( BookingHandler $handler, Event $event = null ) {

		if ( ! $event ) {
			return $this->redirectToRoute( 'front_404', [
				'message' => "Le workshop demandé n'existe pas."
			] );
		}


		return $handler->handle( new Booking(), [ 'event' => $event ] );
	}

	/**
	 * @Route("/galeries", name="front_galleries")
	 */
	public function galleriesAction() {

		$count = sizeof( $this->getDoctrine()->getRepository( Gallery::class )->countNotEmpty() );

		return $this->render( 'front/galleries.html.twig', [
			'galleries' => $this->getDoctrine()->getManager()->getRepository( Gallery::class )->findLasts( MAX_PER_PAGE ),
			'count'     => $count,
			'pages'     => intval( ceil( $count / 5 ) )
		] );
	}

	/**
	 * @Route("/galerie/{slug}", name="front_gallery")
	 * @ParamConverter("event", class="App\Entity\Event")
	 */
	public function galleryAction( Event $event = null ) {

		if ( ! $event ) {
			return $this->redirectToRoute( 'front_404', [
				'message' => "Le workshop demandé n'existe pas."
			] );
		}
		$gallery = $event->getGallery();

		if ( ! $gallery ) {
			return $this->redirectToRoute( 'front_404', [
				'message' => "La galerie demandée n'existe pas."
			] );
		}

		$pictures = $this->getDoctrine()->getRepository( Image::class )->getPictures( $gallery, 0 );


		return $this->render( 'front/gallery.html.twig', [
			"gallery"  => $gallery,
			"pictures" => $pictures,
			"count"    => $this->getDoctrine()->getRepository( Image::class )->countGallery( $gallery )
		] );
	}

	/**
	 * @Route("/service/{slug}", name="front_service")
	 */
	public function serviceAction( $slug ) {

		$manager = $this->getDoctrine()->getManager()->getRepository( Post::class );

		$service = $manager->findService( str_replace( ' ', '-', $slug ) );

		if ( ! $service ) {
			return $this->redirectToRoute( 'front_404' );
		}

		return $this->render( 'front/service.html.twig', [
			'service' => $service
		] );
	}

	/**
	 * @Route("/club", name="front_club")
	 */
	public function clubAction() {

		return $this->render( "front/club.html.twig", [
			'club' => $this->getDoctrine()->getManager()->getRepository( Post::class )->findClub()
		] );

	}

	/**
	 * @Route("/contact", name="front_contact")
	 */
	public function contactAction( ContactHandler $handler ) {

		return $handler->handle( new Contact(), [], 'front/contact.html.twig' );

	}

	/**
	 * @Route("/404", name="front_404")
	 */
	public function notFoundAction( $message = "La page demandée n'existe pas." ) {
		return $this->render( 'front/404.html.twig', [
			'message' => $message
		] );
	}

	/**
	 * @Route("/galerie_ajax/{slug}/{page}", name="front_ajax_gallery", requirements={"page"="\d+"})
	 * @ParamConverter("event", class="App\Entity\Event", options={"mapping": {"slug": "slug"}})
	 */
	public function ajaxGalleryAction( Event $event, $page = 0 ) {

		$first = $page * MAX_PER_GALLERY;

		$datas = $this->getDoctrine()->getRepository( Image::class )->getPictures( $event->getGallery(), $first );

		$serializer = $this->get( 'jms_serializer' );

		return new Response( $serializer->serialize( $datas, 'json' ) );
	}

	/**
	 * @Route("/galeries_ajax/{page}", name="front_ajax_galleries", requirements={"page"="\d+"})
	 */
	public function ajaxGalleriesAction( $page = 0 ) {

		$first = $page * MAX_PER_PAGE;

		$datas = $this->getDoctrine()->getManager()->getRepository( Gallery::class )->findLasts( MAX_PER_PAGE, $first );

		$serializer = $this->get( 'jms_serializer' );

		return new Response( $serializer->serialize( $datas, 'json' ) );
	}

	/**
	 * @Route("/posts_ajax/{page}", name="front_ajax_posts", requirements={"page"="\d+"})
	 */
	public function ajaxPostsAction( $page = 0 ) {
		$first = $page * MAX_PER_PAGE;

		$datas = $this->getDoctrine()->getManager()->getRepository( Post::class )->findLasts( MAX_PER_PAGE, $first );

		$serializer = $this->get( 'jms_serializer' );

		return new Response( $serializer->serialize( $datas, 'json' ) );
	}

	/**
	 * @Route("/events_ajax/{page}", name="front_ajax_events", requirements={"page"="\d+"})
	 */
	public function ajaxEventsAction( $page = 0 ) {
		$first = $page * MAX_PER_PAGE;

		$datas = $this->getDoctrine()->getManager()->getRepository( Event::class )->findLasts( MAX_PER_PAGE, $first );

		$serializer = $this->get( 'jms_serializer' );

		return new Response( $serializer->serialize( $datas, 'json' ) );
	}
}