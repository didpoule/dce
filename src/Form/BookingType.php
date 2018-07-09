<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Formula;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType {

	public function buildForm( FormBuilderInterface $builder, array $options ) {

		$builder
			->add( 'name', TextType::class, [ 'label' => 'nom' ] )
			->add( 'firstname', TextType::class, [ 'label' => 'prénom' ] )
			->add( 'birthday', DateType::class, [
				'label'  => 'date de naissance',

			] )
			->add( 'address', TextType::class, [ 'label' => 'adresse' ] )
			->add( 'zipcode', NumberType::class, [ 'label' => 'code postal' ] )
			->add( 'city', TextType::class, [ 'label' => 'ville' ] )
			->add( 'country', CountryType::class, [
				'label'      => 'pays',
				'empty_data' => 'FR'
			] )
			->add( 'phone', TextType::class, [ 'label' => 'téléphone' ] )
			->add( 'formula', EntityType::class, [
					'class'   => Formula::class,
					'choices' => $builder->getData()->getEvent()->getFormulas(),
					'label'   => 'Formule choisie'
				]

			)
			->add( 'email', EmailType::class, [ 'label' => 'email' ] )
			->add( 'agreeTerms', CheckboxType::class, array(
				'mapped' => false,
				'label'  => 'J\'ai lu et j\'accepte les conditions d\'inscription'
			) )
			->add( 'agreeDatas', CheckboxType::class, array(
				'mapped' => false,
				'label'  => 'J\'accepte que mes données personnelles soient utilisées à des fins d\'information'
			) )
			->add( 'save', SubmitType::class, [
				'label' => 'Envoyer',
				'attr'  => array( 'class' => 'dce-btn dce-btn-red' )
			] );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Booking::class,
		] );
	}
}
