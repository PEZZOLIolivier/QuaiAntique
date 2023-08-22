<?php

namespace App\Form;

use App\Model\WelcomeModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WelcomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
               'label' => "Email"
            ])
            ->add('password', PasswordType::class, [
                'label' => "Mot de passe"
            ])
            ->add('lastName', TextType::class, [
                'label' => "Nom de famille"
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Installer',
                'attr' => [
                    'class' => 'container-button col-10 col-lg-4 btn btn-outline m-1 mb-3 hover'
                ],
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WelcomeModel::class,
        ]);
    }
}