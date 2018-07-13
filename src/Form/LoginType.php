<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire login
 *
 * Class LoginType
 * @package App\Form
 */
class LoginType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->setAction( '/login' )
			->add( '_username', TextType::class, [ 'label' => 'Adresse email' ] )
			->add( '_password', PasswordType::class, [ 'label' => 'mot de passe' ] );
	}
}
