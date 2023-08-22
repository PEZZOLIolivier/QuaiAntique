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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 50 caractères'
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
                    new Regex("^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$^", "Il faut un mot de passe de minimum 8 caratères, avec 1 Majuscule, 1 Minuscule, 1 chiffre et 1 caractère spécial"),
                ],
            ])

            ->add('defaultAllergy', TextType::class, [
                'required' => false,
                'label' => 'Allergies',
                'constraints' => [
                    new Regex("[^&~#'{}!()_%$@<>]", "Vous ne pouvez pas utliser de caractères spéciaux"),
                ],
            ])
            ->add('defaultNbPlaces', IntegerType::class, [
                'required' => false,
                'label' => 'Nombre de place(s) par défaut',
                'constraints' => [
                    new Regex("[^&~#'{}!()_%$@<>]", "Vous ne pouvez pas utliser de caractères spéciaux"),
                ],
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'Prénom',
                'constraints' => [
                    new Regex("[^&~#'{}!()_%$@<>]", "Vous ne pouvez pas utliser de caractères spéciaux"),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 50 caractères'
                    ]),
                ],
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'Nom de famille',
                'constraints' => [
                    new Regex("[^&~#'{}!()_%$@<>]", "Vous ne pouvez pas utliser de caractères spéciaux"),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 50 caractères'
                    ]),
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'N° de téléphone',
                'constraints' => [
                    new Regex("[^&~#'{}!()_%$@<>]", "Vous ne pouvez pas utliser de caractères spéciaux"),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 50 caractères'
                    ]),
                ],
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