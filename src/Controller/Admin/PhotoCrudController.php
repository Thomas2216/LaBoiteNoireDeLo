<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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
            ->setEntityLabelInSingular('Photo')
            ->setEntityLabelInPlural('Photos')
            ->setDefaultSort(['position' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield AssociationField::new('categorie')
            ->setRequired(false)
            ->setHelp('Obligatoire pour une photo de portfolio. Laisser vide pour une photo hors portfolio (ex. la photo de profil).');
        yield TextField::new('titre');
        yield TextField::new('legende');

        yield ImageField::new('imageName', 'Image')
            ->setBasePath('/uploads/photos')
            ->hideOnForm();

        yield TextField::new('imageFile', 'Fichier image')
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions(['required' => false])
            ->onlyOnForms();

        yield IntegerField::new('position');
        yield BooleanField::new('estPortrait', 'Utiliser comme photo de profil (section A propos)')
            ->renderAsSwitch(true);
        yield DateTimeField::new('createdAt')->hideOnForm();
    }
}
