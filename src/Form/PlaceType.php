<?php

namespace App\Form;

use App\Entity\Place;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('address', TextType::class, ['label' => 'Adresse'])
	        ->add( 'save', SubmitType::class, [
		        'label' => 'Envoyer',
		        'attr'  => array( 'class' => 'col-6 mx-auto dce-btn dce-btn-red' )
	        ] );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
    }
}
