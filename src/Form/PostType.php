<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * formulaire article
 *
 * Class PostType
 * @package App\Form
 */
class PostType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'title', TextType::class, [ 'label' => 'Titre' ] )
			->add( 'published', CheckboxType::class, [ 'label' => 'Publier immédiatement', 'required' => false ] )
			->add( 'content', TextareaType::class, [ 'label' => 'Contenu' ] )
			->add( 'image', ImageType::class, [ 'label' => 'Image', 'required' => false ] )
			->add( 'save', SubmitType::class, [
				'label' => 'Sauvegarder',
				'attr'  => array( 'class' => 'dce-btn dce-btn-red' )
			] );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Post::class,
		] );
	}
}
