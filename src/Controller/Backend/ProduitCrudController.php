<?php

namespace App\Controller\Backend;

use App\Entity\Produits\Produit;
use App\Form\Backend\GelerieproduitType;
use App\Form\Backend\MediaprevoirType;
use App\Form\Backend\SpecificationproduitType;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    Field,
    TextField,
    BooleanField,
    NumberField,
    TextareaField,
    ImageField,
    FormField,
    ChoiceField,
    AssociationField,
    CollectionField
};
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Form\Field\CKEditorField;
use App\Form\Field\ImagevichField;


class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }
    public function configureAssets(Assets $assets): Assets
    {
        return Assets::new()->addCssFile('assets/lib/admin/admineyse.css'); 
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
     
 
    public function configureFields(string $pageName): iterable
    {
        switch ($pageName) {
            case Crud::PAGE_INDEX:
                return [
                    AssociationField::new('medias', 'Medias'),
                    TextField::new('titre'),
                    AssociationField::new('sousCategorie'),
                    NumberField::new('position'),
                    BooleanField::new('publier'),
                ];

            default:
                break;
        }
        return [

            
            FormField::addPanel('Information Produit'),
            TextField::new('reference'),
            TextField::new('titre'),
            TextField::new('dimensions'),
            AssociationField::new('categorie'),
            AssociationField::new('sousCategorie'),
            AssociationField::new('interesserProduits'),

            FormField::addPanel('Config & Media'),
            NumberField::new('position'),
            BooleanField::new('publier'),
            //TextareaField::new('imageFile')->setFormType(VichImageType::class),
            CollectionField::new('medias', false)
                ->allowAdd()
                ->allowDelete()
                ->setEntryType(MediaprevoirType::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ]),

            FormField::addPanel('Contenu'),
            CKEditorField::new('contenu', 'Description'),

            FormField::addPanel('Specifications'),
            CollectionField::new('specifications', false)
                ->allowAdd()
                ->allowDelete()
                ->setEntryType(SpecificationproduitType::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ]),

            FormField::addPanel('Geleries'),
            CollectionField::new('galeries', false)
                ->allowAdd()
                ->allowDelete()
                ->setEntryType(GelerieproduitType::class)
                ->setFormTypeOptions([
                    'by_reference' => false
                ]),

            FormField::addPanel('Information Seo'),
            TextField::new('seo_titre'),
            TextareaField::new('seo_description'),
            TextareaField::new('seo_keywords'),

        ];
    } 
 




}
