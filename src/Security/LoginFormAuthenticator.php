<?php

namespace App\Security;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator {

	use TargetPathTrait;

	/**
	 * @var FormFactoryInterface
	 */
	private $formFactory;

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * @var RouterInterface
	 */
	private $router;

	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $passwordEncoder;

	public function __construct( FormFactoryInterface $formFactory, EntityManagerInterface $em, RouterInterface $router, UserPasswordEncoderInterface $passwordEncoder ) {

		$this->formFactory     = $formFactory;
		$this->em              = $em;
		$this->router          = $router;
		$this->passwordEncoder = $passwordEncoder;
	}

	protected function getLoginUrl() {

		return $this->router->generate( 'security_login' );
	}

	public function supports( Request $request ) {
		if ($request->attributes->get('_route') === 'security_login' && $request->isMethod('POST')) {
			return true;
		}
		return false;
	}

	public function getCredentials( Request $request ) {

		$form = $this->formFactory->create( LoginType::class );
		$form->handleRequest( ( $request ) );

		$data = $form->getData();

		$request->getSession()->set(
			Security::LAST_USERNAME,
			$data['_username']
		);

		return $data;

	}

	public function getUser( $credentials, UserProviderInterface $userProvider ) {

		$username = $credentials['_username'];


		return $this->em->getRepository( User::class )->findOneBy( [ 'email' => $username ] );
	}

	public function checkCredentials( $credentials, UserInterface $user ) {

		$password = $credentials['_password'];

		if ( $this->passwordEncoder->isPasswordValid($user, $password) ) {
			return true;
		}

		return false;
	}

	public function onAuthenticationSuccess( Request $request, TokenInterface $token, $providerKey ) {

		$targetPath = $this->getTargetPath( $request->getSession(), $providerKey );
		if ( ! $targetPath ) {
			$targetPath = $this->router->generate( 'back_home' );
		}

		return new RedirectResponse( $targetPath );
	}

}