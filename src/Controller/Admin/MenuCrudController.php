<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name',label: 'Nom du menu'),
            TextField::new('description',label: 'Déscription'),
            MoneyField::new('price')
                ->setCurrency('EUR'),
            AssociationField::new('photo', label: 'Photos')
                ->hideOnIndex(),
            BooleanField::new('isPublish', label: 'Publié'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderContentMaximized()
            ->setEntityLabelInPlural('Menus')
            ->setEntityLabelInSingular('Menu');
    }
}
