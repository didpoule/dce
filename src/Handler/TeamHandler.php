<?php

namespace App\Handler;

use App\Entity\Image;
use App\Entity\Team;
use App\Form\TeamType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class TeamHandler extends Handler {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * TeamHandler constructor.
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

		// Traitement entités existantes
		foreach ( $this->extraData['original'] as $teammate ) {
			// Suppression
			if ( ! $team->getTeammates()->contains( $teammate ) ) {
				$this->em->remove( $teammate );
				// Mise à jour de l'image
			} else {
				if ( $teammate->getImage() && $file = $teammate->getImage()->getFile() ) {
					$image = new Image();
					$teammate->setImage( $image );
					$image->setFile( $file );
					$teammate->getImage()->setAlt( $teammate->getName() );
				}
			}
		}

		// Traitement nouvelles entités
		foreach ( $team->getTeammates() as $teammate ) {
			// Ajout alt Image
			if ( ! $teammate->getImage()->getAlt() ) {
				$teammate->getImage()->setAlt( $teammate->getName() );
			}
			// Ajout relation team
			if ( ! $teammate->getTeam() ) {
				$teammate->setTeam( $team );
			}
		}
		$this->em->persist( $team );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Mise à jour effectuée' );


		return new RedirectResponse( $this->router->generate( 'back_home' ) );
	}

	public function beforeCreate() {
		$original = new ArrayCollection();

		// Sauvegarde des données originales de l'entité
		foreach ( $this->data->getTeammates() as $teammate ) {
			$original->add( $teammate );
		}
		$this->extraData['original'] = $original;
	}
}