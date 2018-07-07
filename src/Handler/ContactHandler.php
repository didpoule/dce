<?php

namespace App\Handler;

use App\Form\ContactType;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class ContactHandler extends Handler {
	private $em;

	private $mailer;

	public function __construct( EntityManagerInterface $em, Mailer $mailer ) {
		$this->em     = $em;
		$this->mailer = $mailer;
	}

	/**
	 * @return string
	 */
	public static function getFormType(): string {
		return ContactType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "front/contact.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {
		$contact = $this->form->getData();

		$this->em->persist( $contact );

		$this->em->flush();

		$this->mailer->sendContact( $contact );

		$this->flashBag->add( 'success', 'Votre message a bien été envoyé.' );

		return new RedirectResponse( $this->router->generate( 'front_contact' ) );

	}

	public function beforeCreate() {
		$this->data->setAdded( new \DateTime() );
	}
}