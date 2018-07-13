<?php

namespace App\Handler;

use App\Entity\Category;
use App\Entity\Image;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\FormHandlerBundle\Handler;

/**
 * Class PostHandler
 * @package App\Handler
 */
class PostHandler extends Handler {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * PostHandler constructor.
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
		return PostType::class;
	}

	/**
	 * @return string
	 */
	public function getView(): string {
		return "back/post.html.twig";
	}

	/**
	 * @return Response
	 */
	public function onSuccess(): Response {
		$post = $this->form->getData();

		// Si une image existait déjà
		if ( $post->getImage()->getId() && $file = $post->getImage()->getFile() ) {
			$image = new Image();
			$post->setImage( $image );
			$post->getImage()->setFile( $file );
		}
		$post->getImage()->setAlt( $post->getTitle() );


		// Ajout de catégorie au post
		if ( ! $post->getCategory() ) {
			$post->setCategory( $this->em->getRepository( Category::class )->findOneBy( [
				'name' => isset( $this->extraData['category'] ) ? $this->extraData['category'] : 'posts'
			] ) );
		}


		$this->em->persist( $post );

		$this->em->flush();

		$this->flashBag->add( 'success', 'Article créé avec succès' );


		return new RedirectResponse( $this->router->generate( 'back_posts' ) );
	}
}