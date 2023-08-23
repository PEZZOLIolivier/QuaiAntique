<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'N° réservation')->onlyOnIndex(),
            DateTimeField::new('date', 'date'),
            TextField::new('lastName', 'Nom de famille'),
            IntegerField::new('nbPlaces', 'Nombre de couverts'),
            TextField::new('allergy', 'Allergie(s)'),
            DateTimeField::new('createdAt', 'créée le')
        ];
    }

}
