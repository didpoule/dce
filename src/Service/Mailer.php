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
	 * @param $datas
	 */
	public function sendContact( $datas ) {
		$this->sendContactClient( $datas );
		$this->sendContactServer( $datas );
	}

	/**
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
}