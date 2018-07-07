<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Post;
use App\Handler\AdminBookingHandler;
use App\Handler\BookingHandler;
use App\Handler\EventHandler;
use App\Handler\GalleryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * Class BackController
 * @package App\Controller
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin")
 */
class BackController extends Controller {

	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Route("/", name="back_home")
	 */
	public function homeAction() {

		$em = $this->getDoctrine()->getManager();

		$event = $em->getRepository( Event::class )->countBooking();

		$contact = $em->getRepository( Contact::class )->countAll();

		$posts = $em->getRepository( Post::class )->countPublished();

		$pictures = $em->getRepository( Image::class )->countTotalPictures();

		return $this->render( 'back/home.html.twig', [
			'event'    => $event,
			'contact'  => $contact,
			'posts'    => $posts,
			'pictures' => $pictures
		] );
	}

	/**
	 * @Route("/workshops", name="back_events")
	 */
	public function eventsAction() {


		return $this->render( 'back/events.html.twig', [
			'events' => $this->getDoctrine()->getRepository( Event::class )->findAll()
		] );
	}

	/**
	 * @param Event $event
	 * @Route("/workshop/{id}", name="back_event")
	 * @ParamConverter("event", class="App\Entity\Event")
	 */
	public function eventAction( EventHandler $handler, Event $event = null ) {

		if ( ! $event ) {
			return $handler->handle( new Event() );
		}

		return $handler->handle( $event );

	}

	/**
	 * @param Event $event
	 * @Route("/workshop/{id}/delete", name="back_event_delete")
	 * @ParamConverter("event", class="App\Entity\Event")
	 */
	public function removeEventAction( Event $event ) {
		if ( $event ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $event );
			$em->flush();

			$this->addFlash( 'success', 'Le workshop a bien été supprimé.' );
		}

		return new RedirectResponse( $this->generateUrl( 'back_events' ) );
	}

	/**
	 * @param Event $event
	 * @Route("/workshop/{id}/bookings", name="back_bookings")
	 * @ParamConverter("event", class="App\Entity\Event")
	 */
	public function bookingsAction( Event $event = null ) {
		if ( $event ) {
			$bookings = $event->getBookings();
		} else {
			$em = $this->getDoctrine()->getRepository( Booking::class );

			$bookings = $em->findAll();
		}

		return $this->render( 'back/bookings.html.twig', [
			'event'    => $event,
			'bookings' => $bookings
		] );
	}

	/**
	 * @param Booking|null $booking
	 * @Route("/booking/{id}", name="back_booking")
	 * @ParamConverter("booking", class="App\Entity\Booking")
	 */
	public function bookingAction(AdminBookingHandler $handler, Booking $booking = null ) {

		return $handler->handle($booking, ['event' => $booking->getEvent()]);
	}

	/**
	 * @param Booking $booking
	 * @Route("/booking/{id}/delete", name="back_booking_delete")
	 * @ParamConverter("booking", class="App\Entity\Booking")
	 */
	public function removeBookingAction( Booking $booking ) {
		if ( $booking ) {
			$em = $this->getDoctrine()->getManager();
			$em->remove( $booking );
			$em->flush();

			$this->addFlash( 'success', 'La réservation a bien été supprimé.' );
		}

		return new RedirectResponse( $this->generateUrl( 'back_bookings' ) );
	}

	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Route("/galleries", name="back_galleries")
	 */
	public function galleriesAction() {

		return $this->render('back/galleries.html.twig', [
			'galleries' => $this->getDoctrine()->getRepository(Gallery::class)->findAll()
		]);
	}

	/**
	 * @Route("/gallery/{id}", name="back_gallery")
	 * @ParamConverter("gallery", class="App\Entity\Gallery")
	 */
	public function galleryAction(GalleryHandler $handler, Gallery $gallery = null) {

		return $handler->handle($gallery);
	}

	/**
	 * @param Gallery $gallery
	 * @Route("/gallery/{id}/delete", name="back_gallery_delete")
	 * @ParamConverter("gallery", class="App\Entity\Gallery")
	 */
	public function removeGalleryAction(Gallery $gallery) {

	}


}