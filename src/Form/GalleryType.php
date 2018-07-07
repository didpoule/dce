<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Gallery;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'event', EntityType::class, [
				'label'         => 'Workshop',
				'class'         => Event::class,
				'query_builder' => function ( EntityRepository $er ) {
					return $er->createQueryBuilder( 'e' );
				},
				'choice_label'  => 'title'
			] )
			->add( 'pictures', PicturesType::class, [ 'label' => 'Ajouter des photos' ] )
			->add( 'published', CheckboxType::class, [ 'label' => 'Publier immédiatement', 'required' => false ] )
			->add( 'save', SubmitType::class, [
				'label' => 'Envoyer',
				'attr'  => array( 'class' => 'dce-btn dce-btn-red' )
			] );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Gallery::class,
		] );
	}
}
