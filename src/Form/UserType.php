<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package App\Form
 */
class UserType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'email', EmailType::class, [ 'label' => 'Email' ] )
			->add( 'plainPassword', RepeatedType::class, [
				'type'            => PasswordType::class,
				'invalid_message' => 'Les mots de passes ne sont pas identiques.',
				'label'           => 'Mot de passe',
				'required'        => true,
				'first_options'   => [ 'label' => 'Mot de passe' ],
				'second_options'  => [ 'label' => 'Répéter le mot de passe' ]
			] )
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
			'data_class' => User::class,
		] );
	}
}
