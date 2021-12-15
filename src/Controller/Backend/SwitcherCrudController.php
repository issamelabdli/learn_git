<?php

namespace App\Controller\Backend;

use App\Entity\Switcher;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud; 
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
        Field,
        TextField,
        BooleanField,
        NumberField,
        TextareaField,
        ImageField,
        FormField,
        ChoiceField
    };  
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class SwitcherCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Switcher::class;
    }
 
    public function configureFields(string $pageName): iterable
    {
        switch ($pageName) {
            case Crud::PAGE_INDEX: 
                return [
                    ImageField::new('image')
                    ->setBasePath(
                        $this->getParameter('app.path.switcher_image')
                    ), 
                    TextField::new('titre'), 
                    NumberField::new('position'),
                    BooleanField::new('publier'),  
                ];   

            default: 
                break;
        }
        return [
            FormField::addPanel('Information'),
             TextField::new('titre'), 
            TextField::new('link'), 
            NumberField::new('position'), 
            BooleanField::new('publier'), 
            TextareaField::new('imageFile')->setFormType(VichImageType::class),
        ];
    } 
}
