<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Gallery;
use App\Entity\Image;
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

		$entity = $builder->getData();

		$builder
			->add( 'event', EntityType::class, [
				'label'         => 'Workshop',
				'class'         => Event::class,
				'query_builder' => function ( EntityRepository $er ) {
					$stmt = $er->createQueryBuilder( 'e' )->getQuery()->getResult();
					foreach ( $stmt as $event ) {
						if ( ! $event->getGallery() ) {
							$results[] = $event;
						}
					}
					$qb = $er->createQueryBuilder( 'e' );
					if(isset($results)) {
						foreach ( $results as $result ) {
							$qb->andWhere( 'e.id = :id' )
							   ->setParameter( 'id', $result->getId() );
						}

						return $qb;
					}
					return null;
				},
				'choice_label'  => 'title',
				'disabled'      => $entity ? true : false
			] )
			->add( 'pictures', PicturesType::class, [
				'label'      => 'Ajouter des photos',
				'data_class' => $entity ? null : Image::class
			] )
			->add( 'published', CheckboxType::class, [ 'label' => 'Publier', 'required' => false ] )
			->add( 'save', SubmitType::class, [
				'label' => 'Envoyer',
				'attr'  => array( 'class' => 'col-6 mx-auto dce-btn dce-btn-red' )
			] );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Gallery::class,
		] );
	}
}
