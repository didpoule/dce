<?php

namespace App\Form;

use App\Entity\Teammate;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'teammates', EntityType::class, [
				'label'         => 'Membres',
				'class'         => Teammate::class,
				'query_builder' => function ( EntityRepository $er ) {
					return $er->createQueryBuilder( 't' );
				},
				'choice_label' => 'name'
			] )
			->add( 'newteammate', CollectionType::class, [
				'label'         => false,
				'entry_type'    => TeammateType::class,
				'allow_add'     => true,
				'allow_delete'  => true,
				'entry_options' => [ 'label' => 'Membre' ]
			] )
			->add( 'save', SubmitType::class, [
				'label' => 'Sauvegarder',
				'attr'  => array( 'class' => 'dce-btn dce-btn-red' )
			] );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			// Configure your form options here
		] );
	}
}
