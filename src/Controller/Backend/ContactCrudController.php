<?php

namespace App\Controller\Backend;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

use EasyCorp\Bundle\EasyAdminBundle\Field\{
    FormField,
    TextField,
    BooleanField,
    AssociationField,
    NumberField,
    EmailField,
    DateTimeField,
    TelephoneField,
    TextareaField
};

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }



    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('created_at');
    }

    
    public function configureFields(string $pageName): iterable
    {
 
        switch ($pageName) {
            case Crud::PAGE_INDEX:
                return [
                    AssociationField::new('produit'),
                    TextField::new('nomcomplet'),
                    EmailField::new('email'),
                    TelephoneField::new('telephone'),
                    DateTimeField::new('created_at')
                ]; 
            default:
                break;
        }
        return [
            FormField::addPanel('Information Contact'),
            AssociationField::new('produit'),
            TextField::new('nomcomplet'),
            EmailField::new('email'),
            TelephoneField::new('telephone'), 
            TextareaField::new('message'),
        ];
    } 
}
