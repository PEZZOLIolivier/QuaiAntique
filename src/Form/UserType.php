<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex('/[a-zA-Z]+$/', 'Vous ne pouvez utiliser que les lettres de A à Z en minuscule et majuscule'),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 50 caractères'
                    ]),
                ],
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex('/[a-zA-Z]+$/', 'Vous ne pouvez utiliser que les lettres de A à Z en minuscule et majuscule'),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 50 caractères'
                    ]),
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
            ])
            //->add('birthday', DateType::class)
            ->add('email', TextType::class)
            ->add('defaultAllergy', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex('/[a-zA-Z]+$/', 'Vous ne pouvez utiliser que les lettres de A à Z en minuscule et majuscule'),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 100 caractères'
                    ]),
                ],
            ])
            ->add('defaultNbPlaces', IntegerType::class, [
                'required' => false,
                'constraints' => [
                    new Regex('/[0-9]+$/', 'Vous ne pouvez utiliser que des chiffres'),
                ],
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