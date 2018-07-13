<?php

namespace App\Service;

/**
 * Class Mailer
 */
class Mailer {

	/**
	 * @var \Swift_Mailer
	 */
	private $mailer;

	/**
	 * @var \Twig_Environment
	 */
	private $twig;

	/**
	 * Mailer constructor.
	 *
	 * @param \Swift_Mailer $mailer
	 */
	public function __construct( \Swift_Mailer $mailer, \Twig_Environment $twig ) {
		$this->mailer = $mailer;
		$this->twig   = $twig;
	}

	/**
	 * Envoie les emails suite a submission formulaire contact
	 *
	 * @param $datas
	 */
	public function sendContact( $datas ) {
		$this->sendContactClient( $datas );
		$this->sendContactServer( $datas );
	}

	/**
	 * Envoie email à l'utilisateur suite a submission formulaire contact
	 *
	 * @param $datas
	 */
	private function sendContactClient( $datas ) {
		$message = ( new \Swift_Message( $datas->getSubject() ) )
			->setFrom( 'contact@danceconceptevent.com' )
			->setTo( $datas->getEmail() )
			->setBody( $this->twig->render(
				'email/contactClient.html.twig', [ 'datas' => $datas ]
			), 'text/html' );

		$this->mailer->send( $message );
	}

	/**
	 * Envoie email à l'administrateur suite a submission formulaire contact
	 *
	 * @param $datas
	 */
	private function sendContactServer( $datas ) {
		$message = ( new \Swift_Message( $datas->getSubject() ) )
			->setFrom( $datas->getEmail() )
			->setTo( 'contact@danceconceptevent.com' )
			->setBody( $this->twig->render(
				'email/contactServer.html.twig', [ 'datas' => $datas ]
			), 'text/html' );

		$this->mailer->send( $message );
	}

	/**
	 * Envoie les emails suite à submission formulaire reservation
	 *
	 * @param $datas
	 *
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	public function sendBooking( $datas ) {
		$this->sendBookingClient($datas);
		$this->sendBookingServer($datas);

	}

	/**
	 * Envoie email au client suite a submission formulaire reservation
	 *
	 * @param $datas
	 *
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	private function sendBookingClient( $datas ) {
		$message = ( new \Swift_Message( $datas->getEvent()->getTitle() ) )
			->setFrom( 'contact@danceconceptevent.com' )
			->setTo( $datas->getEmail() )
			->setBody( $this->twig->render(
				'email/bookingClient.html.twig', [ 'datas' => $datas ]
			), 'text/html' );

		$this->mailer->send( $message );

	}

	/**
	 * Envoie email à l'administrateur suite a submission formulaire reservation
	 *
	 * @param $datas
	 *
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	private function sendBookingServer( $datas ) {
		$message = ( new \Swift_Message( $datas->getEvent()->getTitle() ) )
			->setFrom( $datas->getEmail() )
			->setTo( 'contact@danceconceptevent.com' )
			->setBody( $this->twig->render(
				'email/bookingServer.html.twig', [ 'datas' => $datas ]
			), 'text/html' );

		$this->mailer->send( $message );
	}
}