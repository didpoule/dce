<?php

namespace App\Form;

use App\Entity\Formula;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire formule
 *
 * Class FormulaType
 * @package App\Form
 */
class FormulaType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'name', TextType::class, [ 'label' => 'Nom' ] )
			->add( 'price', TextType::class, [ 'label' => 'Prix' ] );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Formula::class,
		] );
	}
}
