<?php

namespace App\Controller\Admin;

use App\Entity\Dish;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class DishCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dish::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('category', label: 'Catégorie'),
            TextField::new('name',label: 'Nom du plât'),
            TextField::new('description',label: 'Déscription'),
            MoneyField::new('price')
                ->setCurrency('EUR'),
            AssociationField::new('photo', label: 'Photos')
                ->hideOnIndex(),
            BooleanField::new('isPublish', label: 'Publié'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('isPublish')
            ->add('category')
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderContentMaximized()
            ->setEntityLabelInPlural('Plâts')
            ->setEntityLabelInSingular('Plât');
    }
}
