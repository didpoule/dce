<?php

namespace App\Form;

use App\Entity\Team;
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
			->add( 'teammates', CollectionType::class, [
				'label'         => false,
				'entry_type'    => TeammateType::class,
				'allow_add'     => true,
				'allow_delete'  => true,
				'entry_options' => [ 'label' => false ]
			] )
			->add( 'save', SubmitType::class, [
				'label' => 'Sauvegarder',
				'attr'  => array( 'class' => 'dce-btn dce-btn-red' )
			] );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Team::class
		] );
	}
}
