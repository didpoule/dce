<?php

namespace App\Handler;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class UserHandler extends Handler {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * UserHandler constructor.
	 *
	 * @param EntityManagerInterface $em
	 */
	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}

	/**
	 * @return string
	 */
	public static function getFormType(): string {
		return UserType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "back/user.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {
		$user = $this->form->getData();

		// Vérification de l'existance de l'utilisateur en bdd
		if ( $oldUser = $this->em->getRepository( User::class )->findOneBy( [ 'email' => $user->getEmail() ] ) ) {

			// Envoi du nouveau mot de passe pour hashage
			$oldUser->setPlainPassword( $user->getPlainPassword() );

			$this->em->persist( $oldUser );
			$this->em->flush();

			$this->flashBag->add( 'success', 'Mot de passe mis à jour.' );

			return new RedirectResponse( $this->router->generate( 'back_home' ) );

		} else {
			$this->flashBag->add( 'success', "L'adresse email indiquée ne correspond pas." );

			return new RedirectResponse( $this->router->generate( 'back_user' ) );
		}

	}
}