<?php

namespace App\Controller\Backend;

use App\Entity\Categorypage;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

use EasyCorp\Bundle\EasyAdminBundle\Field\{
    Field,
    TextField,
    BooleanField,
    NumberField, 
    ImageField,
    FormField
};
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategorypageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorypage::class;
    }


    public function configureFields(string $pageName): iterable
    {;
 
        switch ($pageName) {
            case Crud::PAGE_INDEX:
                return [ 
                    TextField::new('titre'),
                    NumberField::new('position'),
                ];

            default:
                break;
        }
        return [
            TextField::new('titre'),
            NumberField::new('position'), 

        ];
    }


    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
