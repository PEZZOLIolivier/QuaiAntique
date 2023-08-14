<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer une addresse email valide.',
                    ]),
                ]

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les condiditions',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Accepter les termes.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'required' => true,
                'type' => PasswordType::class,
                'label' => 'Mot de passe' ,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => [
                    'label' => ' ',
                    'attr' => ['class' => 'col 3 my-1 mx-1'],
                ],
                'second_options' => [
                    'label' => ' ',
                    'attr' => ['class' => 'col 3 my-1 mx-1'],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de mettre votre mot de passe',
                    ]),
                ],
            ])

            ->add('defaultAllergy', TextType::class, [
                'required' => false,
                'label' => 'Allergies',
            ])
            ->add('defaultNbPlaces', IntegerType::class, [
                'required' => false,
                'label' => 'Nombre de place(s) par défaut',
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'Nom de famille',
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'N° de téléphone',
            ])
            ->add('birthday', DateType::class, [
                'required' => false,
                'label' => 'Date de naissance',
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}