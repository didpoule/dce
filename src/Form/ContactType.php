<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire contact
 *
 * Class ContactType
 * @package App\Form
 */
class ContactType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'name', TextType::class, [ 'label' => 'nom' ] )
			->add( 'firstname', TextType::class, [ 'label' => 'prénom' ] )
			->add( 'company', TextType::class, [ 'label' => 'Société', 'required' => false ] )
			->add( 'email', TextType::class, [ 'label' => 'email' ] )
			->add( 'subject', TextType::class, [
				'label' => 'Sujet du message',
				'attr'  => [
					'id ' => 'contact-subject'
				]
			] )
			->add( 'content', TextareaType::class, [
				'label' => 'message',
				'attr'  => [
					'id ' => 'contact-content'
				]
			] )
			->add( 'save', SubmitType::class, [
				'label' => 'Envoyer',
				'attr'  => array( 'class' => 'dce-btn dce-btn-red' )
			] );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( [
			'data_class' => Contact::class,
		] );
	}
}
