<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Repository\OpeningHoursRepository;
use App\Repository\UserRepository;
use App\Validator\ReservationDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ReservationType extends AbstractType
{
    private $openingHoursRepository;

    public function __construct(OpeningHoursRepository $repo) {
        $this->openingHoursRepository = $repo;
    }

    private function _getOpeningHours() {
        return $this->openingHoursRepository->findAll();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('POST')
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'reservation js-datepicker',
                ],
                'constraints' => [new ReservationDate($this->_getOpeningHours())]
            ])
            ->add('lastName', TextType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'reservation',
                ],
                'constraints' => [
                    new Regex('/[a-zA-Z]+$/', 'Vous ne pouvez utiliser que les lettres de A à Z en minuscule et majuscule'),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 50 caractères'
                    ]),
                ],
            ])
            ->add('nbPlaces', IntegerType::class,[
                'required' => true,
                'attr' => [
                    'class' => 'reservation',
                ],
                'constraints' => [
                    new Regex('/[0-9]+$/', 'Vous ne pouvez utiliser des chiffres'),
                ],
            ])
            ->add('allergy', TextType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'reservation',
                ],
                'constraints' => [
                    new Regex('/[a-zA-Z]+$/', 'Vous ne pouvez utiliser que les lettres de A à Z en minuscule et majuscule'),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Vous ne pouvez pas utiliser plus de 100 caractères'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}