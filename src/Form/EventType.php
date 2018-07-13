<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Formula;
use App\Entity\Place;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire evenement
 *
 * Class EventType
 * @package App\Form
 */
class EventType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'title', TextType::class, [ 'label' => 'Titre' ] )
			->add( 'added', DateType::class, [ 'label' => 'Date ' ] )
			->add( 'content', TextareaType::class, [ 'label' => 'Informations'] )
			->add( 'published', CheckboxType::class, [ 'label' => 'Publier immédiatement', 'required' => false ] )
			->add( 'image', ImageType::class, [ 'label' => 'Affiche', 'required' => false ] )
			->add('formulas', CollectionType::class, [
				'label' => 'Formules',
				'entry_type' => FormulaType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'entry_options' => ['label' => false]
			])
			->add( 'place', EntityType::class, [
				'label'         => 'Lieu',
				'class'         => Place::class,
				'query_builder' => function ( EntityRepository $er ) {
					return $er->createQueryBuilder( 'p' );
				},
				'choice_label'  => 'name',
			] )
			/*->add('place', PlaceType::class, ['label' => 'Créer nouveau lieu'])*/
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
			'data_class' => Event::class,
		] );
	}
}
