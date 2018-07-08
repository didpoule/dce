<?php

namespace App\Handler;

use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

class TeamHandler extends Handler
{
	private $em;

	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}

    /**
     * @return string
     */
    public static function getFormType(): string
    {
        return TeamType::class;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return "back/team.html.twig";
    }

    /**
     * @return Response
     */
    public function onSuccess(): Response
    {

    	$team = $this->form->getData();

		$this->em->persist($team);

		$this->em->flush();

		$this->flashBag->add('success', 'Mise à jour efféctuée');


    	return new RedirectResponse($this->router->generate('back_home'));
    }

}