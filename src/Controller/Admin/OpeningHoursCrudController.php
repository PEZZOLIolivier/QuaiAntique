<?php

namespace App\Controller\Admin;

use App\Entity\OpeningHours;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class OpeningHoursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OpeningHours::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Horaires')
            ->setEntityLabelInSingular('Horaire')
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        $weekday = ChoiceField::new('day')
            ->setChoices([
                'Lundi' => 'Lundi',
                'Mardi' => 'Mardi',
                'Mercredi' => 'Mercredi',
                'Jeudi' => 'Jeudi',
                'Vendredi' => 'Vendredi',
                'Samedi' => 'Samedi',
                'Dimanche' => 'Dimanche',
            ]);

        return [
            $weekday,
            BooleanField::new('isDayClosed'),
            BooleanField::new('isLunchClosed'),
            TimeField::new('lunchStart')
                ->setFormat("short")
                ->renderAsNativeWidget(),
            TimeField::new('lunchEnd')
                ->setFormat("short")
                ->renderAsNativeWidget(),
            IntegerField::new('lunchMaxPlaces'),
            BooleanField::new('isEveningClosed'),
            TimeField::new('eveningStart')
                ->setFormat("short")
                ->renderAsNativeWidget(),
            TimeField::new('eveningEnd')
                ->setFormat("short")
                ->renderAsNativeWidget(),
            IntegerField::new('eveningMaxPlaces')
        ];

    }
}
