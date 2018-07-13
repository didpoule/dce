<?php

namespace App\Form;

use App\Entity\Place;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire adresse
 *
 * Class PlaceType
 * @package App\Form
 */
class PlaceType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'name', TextType::class, [ 'label' => 'Nom' ] )
			->add( 'address', TextType::class, [ 'label' => 'Adresse' ] )
			->add( 'save', SubmitType::class, [
				'label' => 'Envoyer',
				'attr'  => array( 'class' => 'col-6 mx-auto dce-btn dce-btn-red' )
			] );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Place::class,
		] );
	}
}
