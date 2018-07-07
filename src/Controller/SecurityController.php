<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class SecurityController extends Controller {

	/**
	 * @Route("/login", name="security_login")
	 */
	public function loginAction() {
		$utils = $this->get( 'security.authentication_utils' );

		$error = $utils->getLastAuthenticationError();

		$lastUsername = $utils->getLastUsername();

		$form = $this->createForm(LoginType::class, [
			'_username' => $lastUsername
		]);

		return $this->render( 'security/login.html.twig', [
			'form' => $form->createView(),
			'error'         => $error
		] );
	}

}