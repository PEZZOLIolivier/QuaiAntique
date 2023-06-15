<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Photos')
            ->setEntityLabelInSingular('Photo')
            ->setDefaultSort(['title' =>'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', label: 'Titre'),
            TextField::new('pictureFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('picture', label: 'Photo')
                ->setBasePath('/pictures/photos')
                ->onlyOnIndex(),
            DateField::new('createdAt', label: 'Créé le')
                ->onlyOnDetail(),
            BooleanField::new('isPublish', label: 'Publié'),
        ];
    }
}
