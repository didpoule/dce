<?php

namespace App\Handler;

use App\Entity\Image;
use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class TeamHandler extends Handler {
	private $em;

	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}

	/**
	 * @return string
	 */
	public static function getFormType(): string {
		return TeamType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "back/team.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {

		$team = $this->form->getData();

		foreach ( $team->getTeammates() as $teammate ) {
			if ( $teammate->getImage() && $file = $teammate->getImage()->getFile() ) {
				$image = new Image();
				$teammate->setImage( $image );
				$image->setFile( $file );
				$teammate->getImage()->setAlt( $teammate->getName() );
			}
		}

		$this->em->persist( $team );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Mise à jour effectuée' );


		return new RedirectResponse( $this->router->generate( 'back_home' ) );
	}
}